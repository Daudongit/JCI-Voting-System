$title = 'nominee'
$url = '/admin/nominees/'
function editModal({inputs,button}){
    content = button.data('content')
    inputs[0].value = content.first_name
    inputs[1].value = content.last_name
    inputs[2].value = content.email
    inputs[3].value = content.description
    inputs[4].value = content.image
    $('.MultiFile-preview')[0].src = content.image.split('|')[0]
    $('.MultiFile-title')[0].innerText = content.image
}