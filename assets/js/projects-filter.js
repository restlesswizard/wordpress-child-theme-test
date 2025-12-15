document.addEventListener('DOMContentLoaded', function() {
    const select = document.getElementById('projects-sort');
    const layout = document.querySelector('#projects-grid .projects-grid__layout');

    select.addEventListener('change', function() {
        const sort = this.value;

        const data = new FormData(); // Типа собираем данные в форму для отправки запроса и лепим к ней дальше имя экшена и то, что накликали в селекте
        data.append('action', 'filter_projects');
        data.append('sort', sort);

        // стучимся к wp-ajax.php
        fetch(ajaxurl, {
            method: 'POST',
            body: data,
        })
        .then(res => res.json())
        .then(res => {
            // Обновляем только блок с карточками, чтобы сохранить заголовок и контейнер
            layout.innerHTML = res.html;
        })
        .catch(err => console.error(err));
    });
});
