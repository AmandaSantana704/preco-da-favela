const removeAlert = () => {
    let alertSystem = document.querySelector('.alertSystem');
    if(alertSystem != null){
        setTimeout(() => {
            alertSystem.style.display = 'none';
        }, 5000);
    }
};
removeAlert();

let modalTitle = document.querySelector('.modal-title');
let modalBody = document.querySelector('.modal-body');

function delAction(bt, title, body){
    document.querySelectorAll(`.${bt}`).forEach(element => {
        modalTitle.innerHTML = title;
        modalBody.innerHTML = body;
        element.addEventListener('click', () => {
            document.querySelector('#btConfirmDel').addEventListener('click', () => {
                window.location.href = element.getAttribute('href');
            });
            
        });
    });
}

function delActionForm(bt, title, body){
    document.querySelectorAll(`.${bt}`).forEach(element => {
        modalTitle.innerHTML = title;
        modalBody.innerHTML = body;
        element.addEventListener('click', (e) => {
            e.preventDefault();
            document.querySelector('#btConfirmDel').addEventListener('click', () => {
                  console.log(element.getAttribute('action'));
                  element.submit();
            });
            
        });
    });
}

const limit = (txtEl, txtLen, txtSplit) => {
    $("."+txtEl).each(function (i) {
        var text = $(this).text();
        var len = text.length;
        if (len > txtLen) {
            var query = text.split(" ", txtSplit);
            query.push('...');
            res = query.join(' ');
            $(this).text(res);
        }
    });

}

const activeHover = (search, el, attribute, el2, attribute2) => {
    let busca = new RegExp(search);
    if(busca.exec(window.location.href) != null){
        let element = document.querySelector(el);
            element.classList.add(attribute);
        let element2 = document.querySelector(el2);
            element2.classList.add(attribute2)
    }
}


