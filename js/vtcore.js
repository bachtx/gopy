/**
 * Created by admin on 11/2/14.
 */
$(document).ready(function(){
    validateTextInput();   
    // Submit form comment

    $("#form_comment").submit(function(event) {        
        event.preventDefault();
        var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);

        // var values = $(this).serialize();
        var name = $(".txt_name").val();
        var email = $(".txt_mail").val();
        var content = $(".nicEdit-main").text();

        var values = "txt_name=" + name + "&txt_email=" + email + "&content_comment=" + content;                
        
        if(content.replace(/\s/g, "") == '') {
            alert('Nội dung góp ý không nên bỏ trống. Xin cảm ơn!');
            $(".nicEdit-main").text('');
           return;

        } else if(email != '') {
            if(!pattern.test(email)) {
                alert('Sai định dạng email. Vui lòng kiểm tra lại!');
                return;
            }                            
			else {
				$.ajax({
                url: "ajaxs/ajaxForm.php",
                type: "post",
                data: values,
                success: function(data){
                    if(data == 'error_email') {
                        alert("Định dạng email không cho phép!");
                    }
                    else if(data == 'success') {
                        $(".txt_name").val('');
                        $(".txt_mail").val('');
                        $(".nicEdit-main").html('');
                        autoLoadCounter();
                        alert("Góp ý của bạn đã gửi thành công. Trân trọng cảm ơn!");
                        return;
                    }
                },
                error:function(){
                    alert("Lỗi kết nối tới máy chủ. Vui lòng tải lại trang!");
                }
            });
			}

        } else {
            $.ajax({
                url: "ajaxs/ajaxForm.php",
                type: "post",
                data: values,
                success: function(data){                    
                    if(data == 'error_email') {
                        alert("Định dạng email không cho phép!");
                    }
                    else if(data == 'success') {
                        $(".txt_name").val('');
                        $(".txt_mail").val('');
                        $(".nicEdit-main").text('');
                        autoLoadCounter();
                        alert("Góp ý của bạn đã gửi thành công. Trân trọng cảm ơn!");
                    }
                },
                error:function(){
                    alert("Lỗi kết nối tới máy chủ. Vui lòng tải lại trang!");
                }
            });
        }
    });

    // end submit
    
    //isValidEmailAddress("bac^htx@viettel.com");
})

function autoLoadCounter() {
    var value = 'auto';
     $.post('ajaxs/ajaxForm.php',{'autoload': value}, function(data) {
        $(".no_of").children().html(data);
    });
}

// Kiêm tra giá trị nhập vào các trường text
function validateTextInput(){
    $('.inputValidateText').keyup(function(){
        var input  = $(this).val();
        var leng = input.length;
        if (input == ' ') {
            $(this).val('');
        }
        if (input.charAt(leng-1) == ' '  && input.charAt(leng-2) == ' ') {
            $(this).val(input.substring(0, leng-1));
        }

        if(!validText($(this).val())) {
            var character = "@, #, $, %, ^, &, *, |, ., !, `, ~, ( , ), ...";
            alert("Bạn không được nhập kí tự đặc biệt: " +character);
            var cur = input.substr(0,input.length-1);
            $(this).val(cur);
        }
    })

    $('.inputValidateText').keydown(function(){
        var input  = $(this).val();
        var leng = input.length;
        if (input == ' ') {
            $(this).val('');
        }
        if (input.charAt(leng-1) == ' '  && input.charAt(leng-2) == ' ') {
            $(this).val(input.substring(0, leng-1));
        }

        if(!validText($(this).val())) {
            var character = "@, #, $, %, ^, &, *, |, ., !, `, ~, ( , ), ...";
            alert("Bạn không được nhập kí tự đặc biệt: " +character);
            var cur = input.substr(0,input.length-1);
            $(this).val(cur);
        }
    })

}

//kí tự đặc biệt
function validText(value) {
    var chaos = new Array ("@","#","$","%","^","&","*","|",".", "!" ,"`" , "~" , "( , )" , "...");
    var sum = chaos.length;
    for (var i in chaos) {
        if (!Array.prototype[i]) {
            sum += value.lastIndexOf(chaos[i])
        }
    }

    if (sum) {
        return false;
    } else {
        return true;
    }
}

function isValidEmailAddress(email) {
    var pattern = new RegExp(/^[+a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/i);
    alert(pattern.test(email));
    return pattern.test(email);
};





