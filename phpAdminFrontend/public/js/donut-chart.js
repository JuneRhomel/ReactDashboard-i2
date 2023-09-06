/*
    June Rhomel Mandigma
*/
const circlePersentage = (props) => {
    let html = `
        <div class="circular-container" id="${props.id}">
            <div class="circular-progress">
                <div class="value-content">
                <img src="${props.icon}" alt="">
                </div>
            </div>
            <div class="title">
                <label>${props.title}</label>
                <div class="numProgress">0%</div>
            </div>
        </div>
    `;

    let progress = setInterval(() => {
        props.start++;
        if (props.start <= props.end) {
            // Update the specific elements within the generated HTML
            let color = props.start >= 90 ? '#FFF59F' : (props.start >= 70 ? '#3BBB7F' : '#FF6B6B');
            let container = $('#' + props.id);
            container.find('.numProgress').html(`${props.start}%`);
            container.find('.numProgress').css('color', color);
            container.find('.circular-progress').css(
                'background',
                `conic-gradient(${color} ${props.start * 3.6}deg, #F6F6F6 ${props.start * 3.6}deg)`
            );
        }

        if (props.start === props.end) {
            clearInterval(progress);
        }
    }, props.speed);

    return html;
};
/*
Display
 $('#ID').append(
        circlePersentage({
            title: 'Mechanical',
            start: 0,
            end: 9,
            speed: 10,
            icon: './Group 1660.png',
        })
    );
*/