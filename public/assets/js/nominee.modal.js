$title = 'nominee'
$imagePath = '/storage/upload'
function editModal({inputs,button}){
    const content = button.data('content')
    // const image = content.image?content.image.split('|')[0]: 
    let image = baseUrl.split('admin')[0] 
        image += content.image?$imagePath+'/'+content.image:"/assets/image/no_image.jpg"
    console.log(image);
    inputs[0].value = content.first_name
    inputs[1].value = content.last_name
    inputs[2].value = content.email
    inputs[3].value = content.description
    inputs[4].value = image
    $('.MultiFile-preview')[0].src = image
    $('.MultiFile-title')[0].innerText = image
}