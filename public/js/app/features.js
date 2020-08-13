
let target = document.querySelectorAll('.bt-info');
    let el = document.querySelectorAll('.reveal-element');
    let itemsOffer = document.querySelector('#items-offer');
    target.forEach(bt => {
        bt.addEventListener('click', () => {
            itemsOffer.classList.add('remove');
            el.forEach(item => {
                item.classList.add('remove');
                if(bt.getAttribute('element') === item.getAttribute('target')){
                    if(item.classList.contains('remove')){
                        item.classList.remove('remove');
                    }else{
                        item.classList.add('remove');
                    }
                }
            });

        });
    });

    const removeAll = () => {
        let infoClose = document.querySelectorAll('.info-close');
            infoClose.forEach(Element => {
                Element.addEventListener('click', () => {
                    el.forEach(item => {
                        item.classList.add('remove');
                    });
                    itemsOffer.classList.remove('remove');
                });
            });
    
    }

    // AUTO SUBMIT SELECT FORM
    let filterCategorySearch = document.querySelector('.filterCategorySearch');
        filterCategorySearch.addEventListener('change', function(){
            if(this.value != 0) { this.form.submit(); }
        });
