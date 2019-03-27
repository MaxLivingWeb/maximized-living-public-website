(function(){
    let category = document.getElementById('categoryFilter');
    if (category){
        category.addEventListener('change', categoryChange, false);
    }
    function categoryChange() {
        if(category.options[category.selectedIndex].value === 'Filter by Category') {
            window.location.href = window.location.pathname;
            return;
        }
        window.location.href = window.location.pathname+'?category='+category.options[category.selectedIndex].value;
    }
})();
