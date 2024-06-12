let carousel_s_form = document.getElementById('carousel_s_form');
let carousel_picture_inp = document.getElementById('carousel_picture_inp');



carousel_s_form.addEventListener('submit',function(e){
    e.preventDefault();
    add_image();
}); 

function add_image() {
    let data = new FormData();
    data.append('picture', carousel_picture_inp.files[0]);
    data.append('add_image','');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/carousel_crud.php", true);

    xhr.onload=function(){
        var myModal = document.getElementById('carousel-s');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();

        if (this.response == 'inv_img') {
            alert('error','Định dạng ảnh không được chấp nhận, vui lòng đổi định dạng khác!');
        }
        else if (this.response == 'inv_size') {
            alert('error','Vui lòng chọn ảnh có kích thước dưới 2MB!');
        }
        else if (this.response == 'upd_failed') {
            alert('error','Hệ thống lỗi, vui lòng thử lại sau!');
        }
        else {
            alert('success','Đã thêm ảnh mới!');
            carousel_picture_inp.value = '';
            get_carousel();
        }
    }
    xhr.send(data);
}

function get_carousel() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/carousel_crud.php",true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload=function(){
        document.getElementById('carousel-data').innerHTML = this.responseText;
    }

    xhr.send('get_carousel'); 
}

function rem_image(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST","ajax/carousel_crud.php",true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');

    xhr.onload=function(){
        if (this.response==1) {
            alert('success','Xóa thành công!');
            get_carousel();
        }
        else {
            alert('error','Hệ thống lỗi, vui lòng thử lại!');
        }
    }

    xhr.send('rem_image='+val);
}

window.onload = function(){
get_carousel();
}