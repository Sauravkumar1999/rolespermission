const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

const liElements = document.querySelectorAll('#page-header-flag-dropdown a')
liElements.forEach(li => {
    const img = document.querySelector('#page-header-flag img')
    li.addEventListener('click', (e) => {
        const a = e.currentTarget.querySelector('img').src
        img.src = a
    });
});

const hstackDelete = document.querySelectorAll('.hstack .delete');
hstackDelete.forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault()
        let link = e.currentTarget.href
        if (isValidURL(link) && confirm('Sure to delete')) {
            let tr = e.currentTarget.parentElement.parentElement.parentElement
            fetch(link, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                },
            }).then(r => r.json()).then(data => {
                if (data.status) {
                    Toastify({
                        text: "Success ! data deleted",
                        gravity: "top",
                        position: "right",
                        duration: 3000,
                        close: true
                    }).showToast();
                    tr.remove()
                    return
                }
                Toastify({
                    backgroundColor: "red",
                    stopOnFocus: true,
                    text: "Error ! Faild to delete",
                    gravity: "top",
                    position: "right",
                    duration: 3000,
                    close: true
                }).showToast();
            }).catch(error => {
                console.error(error)
            })
        }
    })
});

const hstackEdit = document.querySelectorAll('.hstack .edit');
hstackEdit.forEach(a => {
    a.addEventListener('click', e => {
        e.preventDefault()
        let link = e.currentTarget.href
        if (link && confirm('Sure to delete')) {
            console.log(link);
        }
    })
});

function isValidURL(url) {
    const urlRegex = /^(ftp|http|https):\/\/[^ "]+$/;
    return urlRegex.test(url);
}
function updateClock() {
    const timer = document.getElementById('timerhead');
    var now = new Date();
    var hours = now.getHours();
    var minutes = now.getMinutes();
    var seconds = now.getSeconds();
    var meridiem = hours >= 12 ? 'PM' : 'AM';
    // Format the time
    hours = hours % 12 || 12;
    minutes = minutes < 10 ? '0' + minutes : minutes;
    seconds = seconds < 10 ? '0' + seconds : seconds;
    var currentTime = hours + ':' + minutes + ':' + seconds + ' ' + meridiem;
    // Update the clock element
    timer.querySelector('span span').textContent = currentTime;
    // Repeat the update every second
    setTimeout(updateClock, 1000);
}
updateClock();
