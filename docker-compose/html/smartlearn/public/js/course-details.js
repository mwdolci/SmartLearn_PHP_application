document.addEventListener('DOMContentLoaded', () => {

    const courseInputs = document.querySelectorAll('input[name="course"]');
    const selectedCourseId = document.getElementById('selected-course-id');

    const description = document.getElementById('course-description');
    const delay = document.getElementById('course-delay');
    const dateStart = document.getElementById('course-date-start');
    const dateEnd = document.getElementById('course-date-end');
    const time = document.getElementById('course-time');
    const days = document.getElementById('course-days');
    const period = document.getElementById('course-period');
    const sites = document.getElementById('course-sites');
    const price = document.getElementById('course-price');

    function updateCourseDetails(input) {
        description.innerHTML = input.dataset.descriptive.replace(/\n/g, '<br>');
        delay.textContent = input.dataset.delay;
        dateStart.textContent = input.dataset.dateStart;
        dateEnd.textContent = input.dataset.dateEnd;
        time.textContent = input.dataset.timeStart.substring(0, 5) + ' - ' + input.dataset.timeEnd.substring(0, 5);
        days.textContent = input.dataset.days;
        period.textContent = input.dataset.period;
        sites.textContent = input.dataset.sites;
        price.textContent = input.dataset.price;
        selectedCourseId.value = input.value;
    }

    courseInputs.forEach(input => {
        input.addEventListener('change', function () {
            updateCourseDetails(this);
        });
    });

    const checked = document.querySelector('input[name="course"]:checked');
    if (checked) {
        updateCourseDetails(checked);
    }
});
