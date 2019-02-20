NodeList.prototype.forEach = NodeList.prototype.forEach || Array.prototype.forEach;
function youtubeThumb(id, name) {
    const thumb = `<img src="https://i.ytimg.com/vi/${id}/hqdefault.jpg" alt="${name} Play Button">`,
        play = '<div class="play"></div>';
    return thumb + play;
}

function youtubeIframe() {
    const iframe = document.createElement('iframe');
    iframe.setAttribute('src', `https://www.youtube.com/embed/${this.dataset.id}?autoplay=1`);
    iframe.setAttribute('frameborder', '0');
    iframe.setAttribute('allowfullscreen', '1');
    this.parentNode.replaceChild(iframe, this);
}

function initYoutube() {
    let div,
        v = document.querySelectorAll('.videoPlayer');

    v.forEach((ele) => {
        div = document.createElement('div');
        div.setAttribute('data-id', ele.dataset.id);
        div.setAttribute('data-name', ele.dataset.name);
        div.innerHTML = youtubeThumb(ele.dataset.id, ele.dataset.name);
        div.onclick = youtubeIframe;
        ele.appendChild(div);
    });
}

initYoutube();
