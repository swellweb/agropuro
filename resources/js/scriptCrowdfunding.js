
    const btnPopup = document.getElementById('btn-popup');
    btnPopup.addEventListener('click', function() {
        debugger;
        const appElement = document.querySelector('#app');
        appElement.__vue_app__._instance.appContext.components.popup.methods.openPopup()
      });


