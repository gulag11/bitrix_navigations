$( document ).ready(function() {
    //todo функция для изменения активного юр лица
    changeLegal();
    //todo функция для изменения данных пользователя
    editLkInfo();
    paginationLk();
    //todo добавление юр лица
    //todo подтверждение товара в заказе
    orderConfirmProduct();
});

function paginationLk() {
    //todo доделать для нескольких data-listing-section на 1 странице

    let parentWindow = $('[data-listing-section]'),
        lazyEntities = parentWindow.data('listing-section'),
        ajaxUrl = parentWindow.data('ajax-url'),
        valuesPage = parentWindow.find('[data-value-page]').val();

    if (!parentWindow.length || !lazyEntities || !valuesPage) {
        return;
    }

    valuesPage = valuesPage.split('/', 2);
    let onAjax = true;

    window.addEventListener('paginationTrigger' + lazyEntities, () => {
        
        if ( valuesPage[0] < valuesPage[1] && onAjax) {
                onAjax = false;
                valuesPage[0]++;
                $.ajax({
                    type: 'GET',
                    url: ajaxUrl + valuesPage[0] + '&typeEvent=' + lazyEntities,
                    dataType: 'html',
                    success: function (res) {
                        $(res).find('[data-lazy-item]').each(function () {
                            parentWindow.append($(this))
                        })
                        onAjax = true;
                        
                        if (valuesPage[0] == valuesPage[1]) {
                            $('[data-animation]').remove();
                        }
                    }
                })
        }


    })
}

function changeLegal (select) {
    let selects = $('[data-change-legal]');
    let arrEvents = [];

    if (select) {
        selects = $(`[data-zone-event=${select}]`);
    }

    selects.each((e, item)=> {
        arrEvents.push($(item).data('zone-event'));
    })

    selects.find('li').on('click', function (){
        const data = {},
            parent = $(this).parent(),
            zoneEvent = parent.data('zone-event');
        data.legalId = $(this).data('legal-id');
        data.typeEvent = 'change_legal';

        $.ajax({
            type: 'POST',
            url: window.location.pathname,
            data: data,
            dataType : 'html',
            success : function (res) {
                switch (zoneEvent) {
                    case 'lk':
                        replace(res, 'replace-lk');
                        changeLegal('lk');
                        break;
                    case 'header':
                        replaceOtherSelector(res, 'main.main');
                        replace(res);
                        changeLegal('lk');
                        changeLegal('header');
                        break;
                    case 'mobile':

                        break;
                }
            }
        });

    })
}

function editLkInfo () {
    
    $('[data-edit-row-lk]').each(function () {
        const row = $(this).find('[data-edit-row]'),
            mainBox = $(this);
        
        $(this).find('[data-edit-lk-target]').each(function () {
            const targetBox = $(this),
                svgEdit = targetBox.find('.profile-page__data-svg'),
                svgOk = targetBox.find('.profile-page__data-ok'),
                input = mainBox.find('input'),
                data = {};
            let state = false;

            $(this).on('click', function () {
                if (!state) {
                    state = true;
                    input.attr('data-state', 'edit');
                    row.removeClass('locked')
                    svgOk.attr('style', 'display:none');
                    svgEdit.attr('style', 'display:block')
                    targetBox.find('.profile-page__data-text').text('Сохранить');
                } else {
                    state = false;
                    data[input.attr('name')] = input.val(); 

                    $.ajax({
                        type: 'POST',
                        url: '/local/templates/main/include/ajax/profiles/edit_lk.php',
                        data: data,
                        dataType : 'json',
                        success : function (res) {
                            if (res.success) {
                                row.addClass('locked');
                                svgOk.attr('style', 'display:block');
                                svgEdit.attr('style', 'display:none')
                                targetBox.find('.profile-page__data-text').text('Изменить');
                            } else {
                                alert(res.message);
                            }
                        }
                    });                    

                }
            })
        })  
    })
}

function replace(r, selector = 'replace') {

    $(`[data-${selector}]`).each((i, item) => {
        const jqObj = $(item),
            link = jqObj.data(selector);

        let linkElem = $(r).filter(`[data-${selector}=${link}]`)

        if (!linkElem.length) {
            linkElem = $(r).find(`[data-${selector}=${link}]`)
        }

        jqObj.empty()
        jqObj.append(linkElem.html())
    })
}

function orderConfirmProduct () {
    $(document).on('click', '[data-сonfirm-product]', function () {
        const data = {
            typeEvent: $(this).data('сonfirm-product'),
            orderId: $(this).data('order-id'),
            elemId: $(this).data('elem-id')
        },
        sibling = $(this).siblings(),
        eventObj = $(this),
        inputVal = $(this).closest('li').find('[data-operator-edit-value]'),
        mainBox = $(this).closest('li');

        if ($(this).data('save-count')) {
            data['count'] = inputVal.val();
        }

        $.ajax({
            type: 'POST',
            url: '/local/templates/main/include/ajax/operator/editOrderProduct.php',
            data: data,
            dataType : 'json',  
            success : function (res) {
                console.log(res);
                if (res.typeEvent == 'addActive' || res.typeEvent == 'unsetActive') {
                    $(sibling).attr('style', '');
                    $(eventObj).attr('style', 'display:none');
                    $(inputVal).toggleClass('locked');
                } else if (res.typeEvent == 'delElem') {
                    $(eventObj).closest('li').remove();
                }

                if (res.elemAllPrice && res.typeEvent == 'addActive') {
                    mainBox.find('[data-all-elem-price]').text(res.elemAllPrice.toLocaleString() + ' ₽');
                }
            
            }
        });


    
    })
}   

function replaceOtherSelector(r, selector = 'replace') {

    $(selector).each((i, item) => {
        const jqObj = $(item);
        let linkElem = $(r).filter(selector);

        if (!linkElem.length) {
            linkElem = $(r).find(selector);
        }

        jqObj.empty()
        jqObj.append(linkElem.html())
    })
}

