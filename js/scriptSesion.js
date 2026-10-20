const openbtn = document.getElementById("openLogin")
const openbtn2 =document.getElementById("openRegister")
const modal = document.getElementById("modal")
const container = document.getElementById("modalContenedor")

openbtn.addEventListener("click", async () => { 

    const res = await fetch("../login.html");
    const html =await res.text();
    container.innerHTML = html;
    modal.style.display = "flex";

    const close = document.getElementById("closeModal")
    close.addEventListener("click",()=> {
        modal.style.display="none";
    });
});

openbtn2.addEventListener("click", async () => {

    const res = await fetch("../register.html");
    const html =await res.text();
    container.innerHTML = html;
    modal.style.display = "flex";

    const close = document.getElementById("closeModal")
    close.addEventListener("click",()=> {
        modal.style.display="none";
    });
});

    window.addEventListener("click",(e)=>{
        if(e.target === modal){
            modal.style.display ="none";
        }
    });


document.addEventListener("click", async (e) => {
  if (e.target && e.target.id === "MostrarA") { 
    const res = await fetch("../login.html");
    const html = await res.text();
    container.innerHTML = html;
    modal.style.display = "flex";

    const close = document.getElementById("closeModal");
    close.addEventListener("click", () => {
    modal.style.display = "none";
    });
    }
});


document.addEventListener("click", async (e) => {
  if (e.target && e.target.id === "MostrarR") { 
    const res = await fetch("../register.html");
    const html = await res.text();
    container.innerHTML = html;
    modal.style.display = "flex";

    const close = document.getElementById("closeModal");
    close.addEventListener("click", () => {
    modal.style.display = "none";
    });
    }
});