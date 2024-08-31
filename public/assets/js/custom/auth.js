let btn = document.querySelector('button.text-muted')
let inp = document.querySelector('div.position-relative .password-input')
btn.addEventListener('click', (e) => {
    if (inp.type === 'password') {
        return inp.setAttribute('type', 'text')
    }
    return inp.setAttribute('type', 'password')
})
