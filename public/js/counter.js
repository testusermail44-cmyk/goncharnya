let buttons = document.querySelectorAll('.counter-btn')

buttons.forEach(element => {
    if (element.id == 'plus')
        element.addEventListener('click', function(event){
            let input = event.target.parentElement.children[1]
            if (Number(input.value) < maxAmount)
                input.value = Number(input.value) + 1
        })
    else
        element.addEventListener('click', function(event){
            let input = event.target.parentElement.children[1]
            if (Number(input.value) > 1)
                input.value = Number(input.value) - 1
        })
});