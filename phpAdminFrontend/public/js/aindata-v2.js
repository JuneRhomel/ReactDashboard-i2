(function ($) {
    $.fn.extend({
        JSDataList: function (options) {
            
            var defaults = {
                title: null,
                ajax: { url: "", type: "POST" },
                onDataChange: null,
                pageLength: 10,
                columns: [],
                rowClass: "",
                headerColumnClass: "",
                headerRowClass: "",
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
                prefix: new Date().getTime(),
                searchBoxID: null,
                filterBoxID: null,
                rowLink: { url: "", params: [] },
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
                            $(obj).find(".aindata-header").not(":first").remove();
                            $(obj).find(".aindata-body").empty();
                            $(obj).next().find(".aindata-info").text("Loading records...");
                        },
                        success: function (json) {
                            console.log(json)
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

                            // if(options.onDataChanged)
                            // {
                            // 	options.onDataChanged.call(obj,json);
                            // }

                            $(obj).find(".datarow").remove();

                            var columns = options.columns;

                            for (i = 0; i < json.data.length - 1; i++) {
                                var headerth = $(obj).find(".aindata-header:first").clone();
                                // $(obj).find(".aindata-body").append(headerth);
                            }


                            $.each(json.data, function (index) {
                                var record = this;
                                var trRow = $("<tr>");
                                trRow.addClass(
                                    "datarow "
                                );
                                if (options.rowClass) trRow.addClass(options.rowClass);

                                if (options.rowLink && options.rowLink.url) {
                                    
                                    // console.log(options.rowLink)
                                    trRow.css("cursor", "pointer");
                                    trRow.on("click", function (e) {
                                        //console.log(e.target.nodeName)
                                        if (
                                            e.target.nodeName != "INPUT" &&
                                            e.target.nodeName != "BUTTON" &&
                                            e.target.nodeName != "A" &&
                                            e.target.nodeName != "SPAN"&&
                                            e.target.nodeName != "I"
                                        ) {
                                            var rowLinkParams = [];
                                            if (options.rowLink.params.length) {
                                                options.rowLink.params.forEach(function (param) {
                                                    rowLinkParams.push(
                                                        param.key +
                                                        "=" +
                                                        (record.hasOwnProperty(param.value)
                                                            ? record[param.value]
                                                            : "")
                                                    );
                                                });
                                            }
                                            
                                            //window.location.href = options.rowLink.url + json.data[index].id
                                            key = (options.rowLink.key) ?? id;
                                            window.location.href = options.rowLink.url + json.data[index][key];
                                            // if (e.target !== e.currentTarget) return;
                                            // console.log(e.target);
                                        }
                                    });
                                }
                                $.each(columns, function (index) {
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

                                        trRow.append(
                                            '<td class="' +
                                            (column.hasOwnProperty("class") ? column.class : "") +
                                            '">' +
                                            // (index == 0
                                            //   ? '<input type="checkbox" class="mr-3 hidden md:inline-block border-1 border-[#B7A8C7] rounded-[3px]">'
                                            //   : "") +
                                            column_text +
                                            "</td>"
                                        );
                                    }
                                });
                                $(".aindata-body").append(trRow);
                            });

                            if (options.onDataChanged) {
                                options.onDataChanged.call(obj, json);
                            }

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
            //end of function

            //initialize JS Data
            if ($(this).find(".aindata-header").length == 0) {
                var thead = $('<thead class="aindata-header-container">');
                var $ainheader = $(
                    '<tr class="aindata-header text-nowrap ' +
                    (obj.options["headerRowClass"]
                        ? obj.options["headerRowClass"]
                        : "") +
                    '"></tr>'
                );
                thead.append($ainheader);
                $(this).append(thead);

                //column headers
                $.each(this.columns, function (index) {
                    var column = $.extend(true, {}, col_default, this);

                    if (column.visible == true) {
                        clsSort = (column.orderable) ? 'sorting' : ''; // 23-0605 atr: hide sorting if orderable=false
                        $ainheader.append(
                            '<th class="text-left ' +
                            (obj.options["headerColumnClass"]
                                ? obj.options["headerColumnClass"]
                                : "") +
                            ' ' + clsSort + ' data-colindex="' +
                            index +
                            '">' +
                            // (index == 0
                            //     ? '<input type="checkbox" id="check-select-all">'
                            //     : "") +
                            this.label +
                            "</th>"
                        );
                    }
                });

                $("#check-select-all").on("change", function () {
                    $(obj)
                        .find("input[type=checkbox]")
                        .not(this)
                        .prop("checked", $(this).prop("checked"));
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
                .on("click", function (e) {
                    //$(obj).find('.aindata-header').children().not($(this)).removeClass('sort_asc');
                    //$(obj).find('.aindata-header').children().not($(this)).removeClass('sort_desc');

                    if (e.target.nodeName == "TH") {
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
                    }
                });

            if ($(this).find(".aindata-body").length == 0) {
                $(this).append(
                    '<tbody class="aindata-body "></tbody>'
                );
            }

            if ($(this).next(".aindata-footer").length == 0) {
                $(
                    `<div class="aindata-footer "><div class="pages-num order-2"></div>
                    </div>`
                ).insertAfter($(this));
            }

            if ($(this).next(".aindata-title").length == 0) {
                $('<div class="aindata-title "></div>').insertBefore($(this));
                if (options.title) $(".aindata-title ").html(options.title);
                if (options.titleClass)
                    $(".aindata-title ").addClass(options.titleClass);
            }

            if (options.filterBoxID) {
                $("#" + options.filterBoxID)
                    .find(".dropdown-menu-filter-fields")
                    .empty();
                var filterfieldcontainercontent = "";
                var column;
                var filterfieldcontainer;
                var filterfieldcontainercontent;
                $.each(this.columns, function (index) {
                    
                    if (this.data && this.label) {
                        // if (this.label == null) this.label = "Unknown";
                        
                        
                        column = $.extend(true, {}, col_default, this);
                        if (column.datatype == "none") {
                            filterfieldcontainer = $('<div class="form-group input-box" style="display: none;"></div>');
                        }
                        else {
                            filterfieldcontainer = $('<div class="form-group input-box"></div>');
                        }
                        if (column.datatype == "select") {
                            const label = this.label.replace(/<\/?br>/g, "")
                            //filterfieldcontainer.append('<div class="mb-0">' +
                            filterfieldcontainercontent =
                                '<div class=" relative select-wrapper">' +
                                '<select name="' + this.data + '" class="filters-select  " required  id="' + this.data + '">' +
                                '<option value="" selected >All </option>' +
                                column.list.map(item => {
                                    const val = item.split("|");
                                   
                                    if(val.length === 2) {
                                        return`<option value="${val[0]}">${val[1]}</option>`
                                    } else {
                                        return`<option value="${item}">${item}</option>`
                                    }
                                }).join('') +
                                '</select>' +
                                '<label for="' + this.data + '" class="">' + label + ' <small class="text-danger">*</small></label>' +
                                '</div>';

                            filterfieldcontainercontent += "</div></div></div>";

                            filterfieldcontainer.append(filterfieldcontainercontent);
                        } else if (column.datatype == "date") {
                            filterfieldcontainer.append(
                                '<div class="input-fields-box">' +
                                '<input type="date" id="' + this.data + '" name="' + this.data + '" class="filters-date input-fields ">' +
                                '<label for="' + this.data + '" class="">' + this.label + '</label>' +
                                '</div>'
                            );
                        } else {
                            filterfieldcontainer.append(
                                '<input type="text" name="' +
                                this.data +
                                '" class="filters-text peer" placeholder="' +
                                this.label +
                                '"></input>' +
                                "<label>" + this.label + "</label>"
                            );
                        }

                        $("#" + options.filterBoxID)
                            .find(".dropdown-menu-filter-fields")
                            .append(filterfieldcontainer);
                    }
                });

                $(".btn-collapse").on("click", function () {
                    $(this).parent().next(".collapse").collapse("toggle");
                });

                $("#" + options.filterBoxID)
                    .find(".btn-filter-now")
                    .on("click", function () {

                        $("#" + options.filterBoxID)
                            .find(".filters-select")
                            .each(function () {
                                obj.column(this.name).searchvalue($(this).val());

                            });
                        $("#" + options.filterBoxID)
                            .find(".filters-date")
                            .each(function () {
                                obj.column(this.name).searchvalue($(this).val());
                            })
                        $("#" + options.filterBoxID)
                            .find(".filters-text")
                            .each(function () {
                                if ($(this).val().replace(" ", "").length > 0) {
                                    obj.column(this.name).searchvalue($(this).val());
                                }
                            });

                        obj.ajax.reload();
                        $("#" + options.filterBoxID).toggle();
                    });

                $("#" + options.filterBoxID)
                    .find(".btn-close-now")
                    .on("click", function () {

                        $("#" + options.filterBoxID)
                            .find(".filters-text")
                            .each(function () {
                                $(this).val("")
                            });
                        $("#" + options.filterBoxID).toggle();
                    })

                $("#" + options.filterBoxID)
                    .find(".btn-reset-now")
                    .on("click", function () {
                        $("#" + options.filterBoxID)
                            .find(".filters-text")
                            .each(function () {
                                $(this).val("")
                            });
                        location.reload();
                        $("#" + options.filterBoxID).toggle();
                    })
            }
            // buttons


            if (options.searchBoxID == null) {
                // console.log(options.addonsclass)
                var searchBoxContainer = $(
                    `<div class='addons ${options.addonsclass? options.addonsclass : ""}'  ></div>`
                );
                options.searchBoxID = "searchbox" + options.prefix;
                searchBoxContainer.append(
                    ' <input type="text" id="' +
                    options.searchBoxID +
                    '" placeholder="Search">'
                );
                searchBoxContainer.append(
                   
                    options.buttons.map(i => {
                        // console.log(i.type.option)
                        if (i.type === "select") {
                            return `
                            <div class="input-box">
                              <select id="${i.id}" class="${i.class ? i.class : ""}">
                                ${i.option.join("")}
                              </select>
                              <label>${i.table}</label>
                            </div>
                            `;
                          }
                          
                        if (i.href) {
                            return `<a href="${i.href}"><button id="${i.id}" class="${i.class}">${i.icon ?? ""} ${i.title} </button></a>`
                        } else {
                            return `<button id="${i.id}" class="${i.class}">${i.icon ?? ""} ${i.title}</button>`
                        }
                    })
                )
                searchBoxContainer.insertBefore($(this));
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
                var btn = $('<button>');
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
                // .append(
                //   '<div class="form-group form-inline float-end"><div class="aindata-pager text-nowrap d-flex align-items-center"></div></div>'
                // );
                .append(
                    '<div class="aindata-pager"></div>'
                );
                $('.pages-num').append('<div class="aindata-info"></div>');

            if (options.paging == true) {
                var selPageLength = $(
                    '<select class="page-length form-control "></select>'
                );
                var btnNext = $(
                    '<button type="button" class="btn-next "disabled> ></button>'
                );
                var btnPrev = $(
                    '<button type="button" class="btn-prev " disabled  ><</button>'
                );
                var selPageNum = $(
                    '<select class="page-num "></select>'
                );
                $(this)
                    .next(".aindata-footer")
                    .find(".aindata-pager")
                    .append(
                        '<div class="pages"><span class="">Showing rows per page </span></div> '
                    );
                var selPageLengthContainer = $("<div>");
                selPageLengthContainer.append(selPageLength);
                $(this)
                    .next(".aindata-footer")
                    .find(".pages")
                    .append(selPageLengthContainer);

                $(this)
                    .next(".aindata-footer")
                    .find(".pages-num")
                    .append(btnPrev);

                $(this)
                    .next(".aindata-footer")
                    .find(".pages-num")
                    .append('<span class="">Page</span>');
                $(this)
                    .next(".aindata-footer")
                    .find(".pages-num")
                    .append(selPageNum);

                $(this)
                    .next(".aindata-footer")
                    .find(".pages-num")
                    .append(btnNext);

                selPageNum.on("change", function () {
                    obj.setStart(($(this).val() - 1) * options.pageLength).ajax.reload();
                });

                pageLengths = [10, 50, 100, 250, 500];
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
