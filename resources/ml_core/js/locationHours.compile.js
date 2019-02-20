NodeList.prototype.forEach = NodeList.prototype.forEach || Array.prototype.forEach;
document.querySelectorAll('.locationDetailTable').forEach( (table) => {
    document.querySelector('.locationDetailHoursExpand').addEventListener('click', () => {
        table.classList.toggle('active');
    });
});
