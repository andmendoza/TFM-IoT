const getBase64FromUrl = async (url) => {
    const data = await fetch(url);
    const blob = await data.blob();
    return new Promise((resolve) => {
        const reader = new FileReader();
        reader.readAsDataURL(blob);
        reader.onloadend = () => {
            const base64data = reader.result;
            resolve(base64data);
        }
    });
}
async function drawImage(url, ctx) {
    let img = new Image();
    console.log(img);
    await new Promise(r => img.onload = r, img.src = url);
    img.style.width = '800px';
    img.style.height = '600px';
    const imagen = document.getElementById('cam-preview');
    imagen.style.display='block';
    imagen.src = img.src;
    ctx.drawImage(img, 0, 0);
}
setInterval(async () => {
    /*         console.log('Buscando Imagen');
            const imagen = document.getElementById('cam-preview');
            const url = imagen.src;
            const timestamp = new Date().getTime(); // crea un timestamp único
            imagen.src = url + '?timestamp=' + timestamp; // actualiza la URL de la imagen
            console.log('Buscando Imagen', timestamp); */
    /* const imagen = document.getElementById('cam-preview');
    getBase64FromUrl(image_url).then((dataImage) =>{
        console.log(dataImage);
        imagen.src = dataImage;
    }); */
    /* const timestamp = new Date().getTime(); 
    const url = image_url+'?timestamp=' + timestamp;
    let ctx = document.querySelector("#myCanvas").getContext("2d");
    await drawImage(url, ctx); */
    const timestamp = new Date().getTime();
    const url = image_url + '?timestamp=' + timestamp;
    let ctx = document.querySelector("#myCanvas").getContext("2d");
    getBase64FromUrl(url).then(async (dataBlob) => {
        console.log('obtenido ' + timestamp);
        await drawImage(dataBlob, ctx);
    });
}, 1000);