$(document).ready(function() {
    // Comment
    controlTab();

    $(".refresh").click(function(){
        location.reload();
    })

    $(".from_date").click(function(){
        $(this).val('');
    })
     $(".to_date").click(function(){
        $(this).val('');
    })     

     removeItem();
})

function controlTab(){
    $(".tab_content").hide();
    $(".tab_content:first").show(); 
    $("ul.tab_menu li").click(function() {
        $("ul.tab_menu li").removeClass("active");
        $(this).addClass("active");
        $(".tab_content").hide();
        var activeTab = $(this).attr("rel"); 
        $("#"+activeTab).fadeIn(); 
    });
}
//end Ready

// Go to page
function gotopage(page)  {
    document.getElementById("txtCurnpage").value=page;
    document.frmpaging.submit();
}

function toggleSlide(obj) {
    var self = jQuery(obj);
    if (self.hasClass('scroll_dow')) {
        self.hide();
        self.parent().children(".scroll_top").show();
        self.parent().parent().children(".comment").css({'height':'200px','overflow':'auto'});
        self.parent().css({'height':'27px','background':'#fff','border':'none'});
    }
    if (self.hasClass('scroll_top')) {
        self.hide();
        self.parent().children(".scroll_dow").show();
        self.parent().parent().children(".comment").css({'height':'65px','overflow':'hidden'});
        $(".reply").removeAttr("style");
        self.parent().css({"height":"45px","background":"#f2f2f2"});
        
    }
}

function removeItem(){
    $(".remove_item").click(function(data){
         if(JQueryConfirm()) {
            var itemId = $(this).attr("itemId");
            $.post("../ajaxs/ajaxForm.php",{"itemId": itemId}, function(data){               
                if(data == 'success') {
                    alert("Bạn đã xóa thành công");
                    location.reload(); 
                }
            })
        }
    })   
}

function JQueryConfirm() {
    return confirm('Bạn có muốn xóa bỏ hay không ?');
}


