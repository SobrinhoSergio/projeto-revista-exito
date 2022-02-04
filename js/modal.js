function iniciaModal(modalID) {
    if(sessionStorage.fechaModal !== modalID) {
        const modal = document.getElementById(modalID);
        if(modal) {
            modal.classList.add('mostrar');
            modal.addEventListener('click', (e) => {
                if(e.target.id == modalID || e.target.className == 'fechar') {
                    modal.classList.remove('mostrar');
                    sessionStorage.fechaModal = modalID;
                }
            });
        }
    }
}

document.addEventListener('scroll', () => {
    if(window.pageYOffset > 800) {
        iniciaModal('modal-promocao')
    }
})