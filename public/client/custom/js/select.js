
    document.addEventListener('click', function(e){
    document.querySelectorAll('[data-custom-select].open').forEach(el=>{
        if(!el.contains(e.target)) el.classList.remove('open');
    });

    const btn = e.target.closest('[data-custom-select] .select-btn');
    if(btn){
    btn.closest('[data-custom-select]').classList.toggle('open');
    return;
}

    const item = e.target.closest('[data-custom-select] .select-list li');
    if(item){
    const box = item.closest('[data-custom-select]');
    box.querySelector('.select-text').textContent = item.textContent;
    box.querySelector('input[type="hidden"]').value = item.dataset.value;
    box.querySelectorAll('li').forEach(li=>li.classList.remove('active'));
    item.classList.add('active');
    box.classList.remove('open');
}
});
