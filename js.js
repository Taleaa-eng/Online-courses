document.querySelector('#login').addEventListener("click",()=>{
    document.querySelector('.popup').classList.add('active')
})

document.querySelector('.btn-close').addEventListener("click",()=>{
    document.querySelector('.popup').classList.remove('active')
});
