(function ($) {
  $.fn.extend({
    JSDataList: function (options) {
      var defaults = {
        ajax: { url: "", type: "POST" },
        onDataChange: null,
        pageLength: 25,
        columns: [],
        rowClass: "row",
        colSearch: {},
        colFilter: {},
        searchDelay: 1000,
        search: { value: "" },
        buttons: [],
        scroller: false,
        paging: true,
        order: [],
        onDataChanged: null,
        buttonNext: null,
        buttonPrev: null,
        start: 0,
        prefix: "",
        searchBoxID: null,
      };
      var options = $.extend(true, {}, defaults, options);
      var start = options.start;
      var searchHandler = null;
      var recordsFiltered = 0;
      var processing = false;
      var sorting = [];

      var obj = this;

      var col_default = {
        data: null,
        name: null,
        render: null,
        class: "col-12 col-sm-1",
        searchable: true,
        search: { value: "" },
        visible: true,
        orderable: true,
        datatype: "text",
      };

      if (options.order.length > 0) {
        $.each(options.order, function () {
          sorting.push({
            column: this[0],
            dir: this[1],
          });
        });
      } else {
        sorting.push({
          column: 0,
          dir: "asc",
        });
      }

      if (
        typeof sessionStorage === "object" &&
        sessionStorage.hasOwnProperty(options.prefix + "_start")
      ) {
        start = parseInt(sessionStorage.getItem(options.prefix + "_start"), 10);
      }

      //functions and properties
      this.columns = options.columns;
      this.options = options;
      this.setStart = function (s) {
        start = s;
        return obj;
      };

      this.start = function () {
        return start;
      };

      this.ajax = {
        reload: function () {
          //$(obj).find('.aindata-body').empty();
          this.load();
        },
        load: function () {
          if (processing) return;

          processing = true;
          options.buttonNext.prop("disabled", "disabled");
          options.buttonPrev.prop("disabled", "disabled");

          var post_columns = [];

          $.each(options.columns, function (index) {
            post_columns[index] = $.extend(true, {}, col_default, this);
            post_columns[index];

            delete post_columns[index].render; //bakit ko ba to dinelete
            if (
              post_columns[index].data &&
              options.colSearch.hasOwnProperty(post_columns[index].data) &&
              options.colSearch[post_columns[index].data]
            ) {
              post_columns[index]["search"]["value"] =
                options.colSearch[post_columns[index].data];
            }
          });

          $.ajax({
            url: options.ajax.url,
            type: "POST",
            data: {
              length: options.pageLength,
              start: start,
              columns: post_columns,
              search: options.search,
              order: sorting,
              filter: options.colFilter,
            },
            dataType: "JSON",
            beforeSend: function () {
              $(obj).find(".aindata-body").empty();
              $(obj).next().find(".aindata-info").html("Loading records...");
            },
            success: function (json) {
              recordsFiltered = parseInt(json.recordsFiltered);
              recordsTotal = parseInt(json.recordsTotal);
              recordsLength = parseInt(json.data.length);

              totalPage = Math.ceil(recordsFiltered / options.pageLength);

              info_misc = "";
              if (options.scroller) {
                start += json.data.length;

                info_start = recordsLength > 0 ? start + 1 : 0;
                info_end =
                  recordsLength < options.pageLength
                    ? json.data.length + start
                    : options.pageLength + start;
                //removed advised by boss edss
                //info_misc = (recordsFiltered < recordsTotal ? ' (filtered from ' + recordsTotal + ' records)' : '');

                $(obj)
                  .next()
                  .find(".aindata-info")
                  .html(
                    "Showing " +
                      (recordsFiltered > 0 ? 1 : 0) +
                      " to " +
                      start +
                      " of " +
                      obj.numberWithCommas(recordsFiltered) +
                      " records" +
                      info_misc
                  );
              } else {
                info_start = recordsLength > 0 ? start + 1 : 0;
                info_end =
                  recordsLength < options.pageLength
                    ? json.data.length + start
                    : options.pageLength + start;
                //removed advised by boss edss
                //info_misc = (recordsFiltered < recordsTotal ? ' (filtered from ' + recordsTotal + ' records)' : '');

                if (recordsFiltered > options.pageLength) {
                  $(obj)
                    .next()
                    .find(".aindata-info")
                    .html(
                      "Showing " +
                        obj.numberWithCommas(info_start) +
                        " to " +
                        (recordsLength > 0
                          ? obj.numberWithCommas(info_end)
                          : 0) +
                        " of " +
                        obj.numberWithCommas(recordsFiltered) +
                        " record" +
                        (recordsFiltered > 1 ? "s" : "") +
                        info_misc
                    );
                } else if (recordsLength > 0) {
                  $(obj)
                    .next()
                    .find(".aindata-info")
                    .html(
                      obj.numberWithCommas(recordsFiltered) +
                        " record" +
                        (recordsFiltered > 1 ? "s" : "") +
                        info_misc
                    );
                } else {
                  $(obj).next().find(".aindata-info").html("No record found");
                }

                $(".page-num option").remove();

                for (pageNum = 0; pageNum < totalPage; pageNum++) {
                  $(".page-num").append(
                    "<option>" + (pageNum + 1) + "</option>"
                  );
                }
                $(".page-num").val(Math.ceil(info_start / options.pageLength));
              }

              if (options.onDataChanged) {
                options.onDataChanged.call(obj, json);
              }

              $(obj).find(".datarow").remove();
              var columns = options.columns;
              $.each(json.data, function () {
                var record = this;
                var dataRowContainer = $("<div>");
                dataRowContainer.addClass("p-2 rounded bg-white mt-2");
                var dataRow = $("<div>");
                dataRow.addClass("datarow row row-list");
                $.each(columns, function () {
                  var column = this;
                  if (
                    !column.hasOwnProperty("visible") ||
                    column.visible == true
                  ) {
                    var column_text = "";
                    if (column.hasOwnProperty("render") && column.render) {
                      column_text = column.render(record[column.data], record);
                    } else if (column.data) {
                      column_text =
                        record[column.data] == null ? "" : record[column.data];
                    }

                    dataRow.append(
                      '<div class="col-3 col-lg-3 col-xl-3  d-block d-lg-none d-xl-none" style="font-weight: bold;"> ' +
                        column.label +
                        ' </div><div class="col-9 ' +
                        (column.hasOwnProperty("class") ? column.class : "") +
                        '">' +
                        column_text +
                        "</div>"
                    );
                  }
                });
                dataRowContainer.append(dataRow);
                $(obj).find(".aindata-body").append(dataRowContainer);
              });

              if (start + options.pageLength < recordsFiltered) {
                options.buttonNext.prop("disabled", false);
              }

              if (start > 0) {
                options.buttonPrev.prop("disabled", false);
              }
              processing = false;
            },
            complete: function () {
              processing = false;
            },
            error: function (jqXHR, textStatus, errorThrown) {
              processing = false;
            },
          });
        },
      };

      this.column = function (key) {
        this.search = function (text) {
          start = 0;
          options["colSearch"][key] = text;
          obj.ajax.reload();
        };

        this.searchvalue = function (text) {
          options["colSearch"][key] = text;
        };

        this.order = function (dir) {
          sorting[0]["column"] = key;
          sorting[0]["dir"] = dir;

          start = 0;
          obj.ajax.reload();
        };
        return this;
      };

      this.next = function () {
        if (processing) return;

        if (start < recordsFiltered) {
          //start += options.pageLength;
          if (options.scroller == true) {
            obj.ajax.load();
          } else {
            obj.ajax.reload();
          }
        } else {
          start =
            Math.floor(recordsFiltered / options.pageLength) *
            options.pageLength;
          processing = false;
        }

        return start + options.pageLength < recordsFiltered;
      };

      this.previous = function () {
        if (processing) return;

        if (start >= 0) {
          if (options.scroller == true) {
            obj.ajax.load();
          } else {
            obj.ajax.reload();
          }
        } else {
          start = 0;
          processing = false;
        }

        return start > 0;
      };

      this.find = function (text) {
        start = 0;
        obj.options["search"]["value"] = text;
        obj.ajax.reload();
      };

      this.numberWithCommas = function (x) {
        var parts = (x + "").toString().split(".");
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        return parts.join(".");
      };
      //end of functions

      //initialize JS Data
      if ($(this).find(".aindata-header").length == 0) {
        //var $ainheader = $('<tr class="aindata-header text-nowrap"></tr>');
        var $ainheadercontainer = $("<div>");
        $ainheadercontainer.addClass(
          "p-2 rounded bg-white mt-2 d-none d-lg-block"
        );
        var $ainheader = $("<div>");
        $ainheader.addClass("row aindata-header text-nowrap");
        $ainheadercontainer.append($ainheader);
        $(this).append($ainheadercontainer);

        //column headers
        $.each(this.columns, function (index) {
          var column = $.extend(true, {}, col_default, this);

          if (column.visible == true) {
            $ainheader.append(
              '<div class="col ' +
                (this.hasOwnProperty("class") ? this.class : "") +
                (column.orderable ? " sorting" : "") +
                '" data-colindex="' +
                index +
                '">' +
                this.label +
                "</div>"
            );
          }
        });

        //show default sort icon
        $.each(sorting, function () {
          $ainheader
            .find(".sorting")
            .eq(this.column)
            .addClass("sort_" + this.dir);
        });
      }

      $(obj)
        .find(".aindata-header")
        .find(".sorting")
        .off("click")
        .on("click", function () {
          //$(obj).find('.aindata-header').children().not($(this)).removeClass('sort_asc');
          //$(obj).find('.aindata-header').children().not($(this)).removeClass('sort_desc');

          $(obj)
            .find(".aindata-header")
            .find(".sorting")
            .not($(this))
            .removeClass("sort_asc");
          $(obj)
            .find(".aindata-header")
            .find(".sorting")
            .not($(this))
            .removeClass("sort_desc");

          sorting[0]["column"] = $(this).data("colindex")
            ? $(this).data("colindex")
            : $(this).index();
          if ($(this).hasClass("sort_asc")) {
            $(this).addClass("sort_desc");
            $(this).removeClass("sort_asc");
            sorting[0]["dir"] = "desc";
          } else {
            $(this).addClass("sort_asc");
            $(this).removeClass("sort_desc");
            sorting[0]["dir"] = "asc";
          }

          start = 0;
          obj.ajax.reload();
        });

      if ($(this).find(".aindata-body").length == 0) {
        $(this).append('<div class="aindata-body"></div>');
      }

      if ($(this).next(".aindata-footer").length == 0) {
        $('<div class="aindata-footer p-3"></div>').insertAfter($(this));
      }

      if (options.searchBoxID) {
        $("#" + options.searchBoxID)
          .off("keyup")
          .on("keyup", function (e) {
            if (e.which >= 37 && e.which <= 40) return;

            var searchValue = $(this).val();
            if (searchValue.length >= 3 || searchValue == "") {
              clearTimeout(searchHandler);
              searchHandler = setTimeout(() => {
                obj.find(searchValue);
              }, obj.options.searchDelay);
            }
          })
          .off("keydown")
          .on("keydown", function (e) {
            if (e.which >= 37 && e.which <= 40) return;
            clearTimeout(searchHandler);
          });
      }

      //buttons
      $.each(options.buttons, function () {
        var btn = $('<button class="btn">');
        btn.html(this.text);

        if (this.hasOwnProperty("className")) {
          btn.addClass(this.className);
        }
        if (this.action) {
          var action = this.action;
          btn.on("click", function () {
            action.call(obj);
          });
        }

        $(obj)
          .prev(".aindata-toolbar")
          .find(".aindata-buttons .btn-group")
          .append(btn);
      });

      $(this)
        .next(".aindata-footer")
        .append(
          '<div class="form-group form-inline float-end"><div class="aindata-pager text-nowrap d-flex align-items-center"></div></div>'
        );
      $(this)
        .next(".aindata-footer")
        .append('<div class="aindata-info"></div>');

      if (options.paging == true) {
        var selPageLength = $(
          '<select class="page-length form-control me-2"></select>'
        );
        var btnNext = $(
          '<button type="button" class="btn btn-primary btn-next me-2" disabled>Next <span class="fa fa-caret-right"></span></button>'
        );
        var btnPrev = $(
          '<button type="button" class="btn btn-primary btn-prev me-2" disabled><span class="fa fa-caret-left"></span> Previous</button>'
        );
        var selPageNum = $(
          '<select class="page-num form-control ml-2"></select>'
        );
        $(this)
          .next(".aindata-footer")
          .find(".aindata-pager")
          .append('<span class="me-1">Number of rows</span> ');
        $(this)
          .next(".aindata-footer")
          .find(".aindata-pager")
          .append(selPageLength);
        $(this).next(".aindata-footer").find(".aindata-pager").append(btnPrev);
        $(this).next(".aindata-footer").find(".aindata-pager").append(btnNext);
        $(this)
          .next(".aindata-footer")
          .find(".aindata-pager")
          .append('<span class="me-1">Page</span>');
        $(this)
          .next(".aindata-footer")
          .find(".aindata-pager")
          .append(selPageNum);

        selPageNum.on("change", function () {
          obj.setStart(($(this).val() - 1) * options.pageLength).ajax.reload();
        });

        pageLengths = [25, 50, 100, 250, 500];
        if (!pageLengths.includes(options.pageLength))
          pageLengths.push(options.pageLength);
        pageLengths.sort((a, b) => a - b);
        pageLengths.forEach(function (item) {
          selPageLength.append(
            '<option value="' + item + '">' + item + "</option>"
          );
        });
        selPageLength.on("change", function () {
          obj.options.pageLength = parseInt($(this).val());
          options.pageLength = parseInt($(this).val());
          obj.ajax.reload();
        });

        btnNext.on("click", function () {
          start += options.pageLength;
          var n = obj.next();
          if (!n) {
            $(this).prop("disabled", "disabled");
          }

          if (typeof sessionStorage === "object") {
            sessionStorage.setItem(options.prefix + "_start", start);
          }

          $(".page-num").val(Math.ceil(start / options.pageLength));
        });

        btnPrev.on("click", function () {
          start -= options.pageLength;
          var n = obj.previous();
          if (!n) {
            $(this).prop("disabled", "disabled");
          }

          if (typeof sessionStorage === "object") {
            sessionStorage.setItem(options.prefix + "_start", start);
          }
          $(".page-num").val(Math.ceil(start / options.pageLength));
        });

        if (!options.buttonNext) options.buttonNext = btnNext;
        if (!options.buttonPrev) options.buttonPrev = btnPrev;
      }

      if (options.ajax.url) {
        this.ajax.load();
      }

      if (options.scroller) {
        $(window).scroll(function () {
          if (
            $(window).scrollTop() + $(window).height() >
            $(document).height() - 100
          ) {
            obj.next();
          }
        });
      }

      return this;
    },
  });
})(jQuery);
