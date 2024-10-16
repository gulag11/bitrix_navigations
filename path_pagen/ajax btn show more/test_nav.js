document.addEventListener('DOMContentLoaded', function() { 
    show_more_fetch();
});

// функция для кнопки показать еще, принимает номер пагинации для какой мы ее вызываем,
function show_more_fetch () {
    let btn = document.querySelector(`[js-show-more]`);
    if (btn) {
        btn.addEventListener('click', () => {
            let parent = btn.closest('[js-elems-box]'),
                nav = btn.closest('[js-nav-box]'),
                url = btn.getAttribute('js-show-more');
            // 'X-Requested-With' : 'XMLHttpRequest' заголовок для отслеживания ajax
            let queryParam = {
                headers: {
                    'Content-Type' : 'text/html',
                    'X-Requested-With' : 'XMLHttpRequest'
                },
                method: 'GET',
            };

            fetch(url, queryParam)
                .then(response => {return response.text()})
                .then(html => {
                    html = document.createRange().createContextualFragment(html).querySelector('[js-elems-box]');
                    nav.remove();
                    parent.innerHTML += html.innerHTML;
                    history.pushState(null, null, window.location.origin + url);
                    // вызываем эту же функцию для новой кнопки которую мы заменили
                    show_more_fetch();
                })
                .catch(error => console.log(error));
        })
    }
}

// <<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<

BX.ready(function(){
    // show_more_BX();
});

function show_more_BX () {
    let btn = document.querySelector(`[js-show-more]`);
    if (btn) {
        BX.bind(btn, 'click', function (e) {
            let parent = btn.closest('[js-elems-box]'),
                nav = btn.closest('[js-nav-box]');
            BX.ajax({
                url: btn.getAttribute('js-show-more'), 
                method: 'GET',
                processData: false, 
                preparePost: false, 
                onsuccess: function(html) {
                    html = document.createRange().createContextualFragment(html).querySelector('[js-elems-box]');
                    nav.remove();
                    parent.innerHTML += html.innerHTML;
                    // вызываем эту же функцию для новой кнопки которую мы заменили
                    show_more_BX();
                },
                onfailure: function(error) {
                    console.log(error)
                }
            });
        })
    }
}
