import './bootstrap';
formulaire2.onsubmit(initializeApp);
function initializeApp(callbackUrl) {
    var formulaire2=document.querySelector(".formulaire2");
    formulaire2.onsubmit=(e)=>{
        e.preventDefault();
        console.log(formulaire2.montant.value);
        openKkiapayWidget({amount:formulaire2.montant.value,position:"center",callback:callbackUrl,
                    data:"",
                    theme:"#308747",
                    sandbox:true,
                    key:"e1ed75f092f611eeb66e33e3292024ab"})
    }
}