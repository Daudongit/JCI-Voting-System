$modal = 'nominee'
function editModal(inputs,content){
    inputs[0].value = content.first_name
    inputs[1].value = content.last_name
    inputs[2].value = content.email
    inputs[3].value = content.discription
    inputs[4].value = content.image
    //$('.MultiFile-preview')[0].src = window.baseUrl+'/assets/image/'+'profile-avatar.jpg'
    $('.MultiFile-preview')[0].src = content.image
    //$('.MultiFile-title')[0].innerText = content.image+'.jpg'
    $('.MultiFile-title')[0].innerText = content.image
    //console.log(inputs)
}