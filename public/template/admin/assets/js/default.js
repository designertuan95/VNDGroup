/* <![CDATA[ */  
var Product = {};
var Order = {};
Order.DiscountSuccess = 0;

Order.Customer = {};
Order.Information = {};
Order.Information.DiscountText = '0 ₫';
Order.Information.LineItem = [];
Order.Information.DiscountValue = 0;
Order.TotalItemOrder = 0;
Order.Information.lineCount = 0;
Order.Product = {};
searchProduct = {};
searchProduct.showProduct = $('#showProduct ul');

Order.Information.closeResultSearch = function(){
  $('.box-search-advance.product .panel-default').removeClass('active');
}
Order.onInit = function(){
  // Discount settup
  Order.Information.InputDiscount = $('#valueDiscount');
  Order.Information.InputDiscount.attr('typeDiscount','VND');
  $('button[value=percentage]').click(function(){
    // Set Type Discount
    Order.Information.InputDiscount.attr('typeDiscount','%');
    Order.Information.DiscountText = $(this).text();
    $('#textTypeDiscount').text(Order.Information.DiscountText);  
    $(this).addClass('active  btn-active');
    $('button[value=fixed_amount]').removeClass('active');
  });

  $('button[value=fixed_amount]').click(function(){
    Order.Information.DiscountText = $(this).text();
    Order.Information.InputDiscount.attr('typeDiscount','VND');
    $('#textTypeDiscount').text(Order.Information.DiscountText);  
    $(this).addClass('active  btn-active');
    $('button[value=percentage]').removeClass('active');
  });
  // End Discount settup

  // Shipping settup
  $('input[name=shipping_method]').click(function(){
    Order.Information.ShippingMethod = $(this).val();
    if(Order.Information.ShippingMethod == 'free-shipping'){
       $('#addShipping .modal-footer .pull-right button').removeAttr('disabled');
    }else{
     
      $('#addShipping .modal-footer .pull-right button').removeAttr('disabled');
    }
  })
  // Add Customer
  $('.textbox-advancesearch').click(function(){
    $('.box-search-advance.customer .panel-default').toggleClass('active');
    
  });
  // Search Customer
 
  // End find Customer
  // Find Product
  var timeout;
  $("input#searchPrd").on('keyup',function(e){
      var $this = $(this);
      if(timeout) {
            clearTimeout(timeout);
        }
        timeout = setTimeout(function() {
          var QueryString = $this.val();
          if(QueryString.length > 0){
            Order.Product.getProduct(QueryString);
          }
        }, 300);
  })
  // End Find Product
  $('#addCustomer .pull-right button').on('click',function(){
    Order.Customer.Data = $('#addCustomer form').serialize();
    var urlAction = $('#addCustomer form').attr('action');
    Order.Customer.QuickAdd(urlAction);
    console.log(Order.Customer.Data);
  })

  
}
Order.onInit();
// Add Cusstomer 
$(document).ready(function(){
  Order.Customer.getCustomer();
  Order.Product.getProduct();
})
// Lấy thông tin sản phảm
Order.Product.getProduct = function(QueryString = ''){
        $.ajax({
            url: '/admin/products/searchProduct',
            type: "GET",
            data: {Query:QueryString},
            success: function (response) {
              console.log(QueryString);
              $('.box-search-advance.product .panel-default').addClass('active');
              $('input#searchPrd').focus();
              $('.list-search-data-prd').html(response);
            }

        });
}
// Hiển thị tổng tiền cho sản phẩm
Order.Information.showTotalItems = function(){
  total = Order.Information.caculateTotalLineItemPrice();
  var FormatTotal = Order.FormatPrice(1,total);
  $('#TotalItemOrder').text(FormatTotal+ ' đ');

}
// Thêm giảm giá, khuyến mãi
Order.Information.addDiscount = function(){
  Order.Information.DiscountValue = $('#valueDiscount').val();
  Order.Information.TypeDiscount = $('#valueDiscount').attr('typediscount');
  Order.Information.showTotalItems();
  $('#addDiscount .close').click();
  addInputDiscount();

}
// Phương thực thêm phí ship
Order.Information.AddShipping = function(){
  var ElementShipping = $('#addShipping');
  if(Order.Information.ShippingMethod == 'free-shipping'){
    $('#addShipping button.close').click();
    Order.Information.ShippingMethodName = 'free';
    Order.Information.OrderShippingFee = 0;
    $('#Shipping').html('Miễn Phí vận chuyển');
    $('#ShippingValue').text('0 đ');
  }else{
    Order.Information.ShippingMethodName = $('#ShippingMethodName').val();
    Order.Information.OrderShippingFee = $('#OrderShippingFee').val();
     $('#Shipping').html(Order.Information.ShippingMethodName);
     Order.ValueShipping = Order.FormatPrice(1,Order.Information.OrderShippingFee);
     $('#ShippingValue').text(Order.ValueShipping+ ' đ');
     $('#addShipping button.close').click();
  }
  addInputShipping();
}
// Tính tiền cho sản phẩm
Order.Information.caculateTotalLineItemPrice = function () {
  // Đặt tổng tiền mặc định là 0
  var totalPrice = 0;
  // Thực hiện lặp qua mảng chưa thông tin sản phẩm
  if(this.LineItem.length > 0){
    for (var i = 0; i < this.LineItem.length; i++) {
      // Mỗi lần chạy qua vòng lặp sẽ + tiền
      totalPrice += this.LineItem[i].price * this.LineItem[i].quantity;
    }
    // Hiển thị nút thanh toán
    $('.rps-float-none.pull-right button').removeAttr('disabled');
  }
  // Nếu có giảm giá thì tính trừ giảm giá
  if(Order.Information.DiscountValue > 0 || Order.Information.DiscountValue.length > 0){
    // Giảm tiền trực tiếp
    if(Order.Information.TypeDiscount == 'VND'){
      totalPrice -= Order.Information.DiscountValue;
      Order.DiscountSuccess = Order.Information.DiscountValue;
      // Hiển thị giá trị khuyến mãi
      $('#DiscountOrder').text(Order.Information.DiscountValue);
    }
    if(Order.Information.TypeDiscount == '%'){
      // Giản giá theo %
      var TotalPhanTram = totalPrice/100;
      var value = TotalPhanTram * Order.Information.DiscountValue;
      totalPrice -= value;
      Order.DiscountSuccess = value;
    }
    
  }
  // Hiển thị giá trị khuyến mãi
  $('#DiscountOrder').text(Order.FormatPrice(1,Order.DiscountSuccess)+ ' đ');
  return totalPrice;
}
function addInputDiscount(){
  $('input[name=TypeDiscount]').val(Order.Information.TypeDiscount);
  $('input[name=DiscountValue]').val(Order.Information.DiscountValue);
}
function addInputShipping(){
  $('input[name=ShippingMethodName]').val(Order.Information.ShippingMethodName);
  $('input[name=OrderShippingFee]').val(Order.Information.OrderShippingFee);
}
function addInput(name,value){
  return '<input name="'+name+'" value="'+value+'">';
}
Order.Information.removeLineItem = function(line){
  // Remove Html
  $('.line_item_'+line).remove();
  // Remove LineItem
  Order.Information.LineItem.splice(line,1);
  Order.Information.showTotalItems();

}
Order.Information.addLineItemOrder = function($objItem){
  Order.Product.ItemInfo = $objItem;
  var Price = Order.FormatPrice(1,Order.Product.ItemInfo.price);
  var xHtml = '<tr class="line_item_'+Order.Information.lineCount+' variant_id_'+Order.Product.ItemInfo.product_id+'" item-index="0">';
    xHtml += '<td><div class="thumb"><img alt="" class="block aspect-ratio__content" src="'+Order.Product.ItemInfo.image+'"></div></td>';
    xHtml += '<td width="45%"><div class="title"><a target="_blank" href="'+Order.Product.ItemInfo.urlProduct+'">'+Order.Product.ItemInfo.name+'</a></div></td>';
    xHtml += '<td><small class="block price-discounted hide">'+Order.Product.ItemInfo.price+'<span>₫</span></small><span class=""><a href="" class="btn--link"><span class="line_item_0_price">'+Order.Product.ItemInfo.price+'₫</span></a></span></td><td class="subdued">x</td>';
    xHtml += '<td style="min-width: 95px; width: 95px;"><div class="next-input-wrapper"><input class="form-control input-group-sm" max="1000000" min="1" size="30" value="'+Order.Product.ItemInfo.quantity+'" type="number" onkeyup="Order.Information.changeQuantity(this.value,'+Order.Product.ItemInfo.price+','+Order.Information.lineCount+')" ></div></td>';
    xHtml += '<td class="type--right" id="totalItem">'+Price+'₫</td><td class="type-right"><a class="remove-line-item" onclick="Order.Information.removeLineItem('+Order.Information.lineCount+')"><i class="fa fa-times color-stateGray"></i></a></td>"';
    xHtml += '<input type="hidden" id="product_id_'+Order.Information.lineCount+'" name="product_id['+Order.Product.ItemInfo.product_id+']" value="'+Order.Product.ItemInfo.quantity+'"></tr>';
  $('#listItem').append(xHtml);

  // Add line Item
  Order.Information.LineItem[Order.Information.lineCount] = {
    price:Order.Product.ItemInfo.price,
    quantity:Order.Product.ItemInfo.quantity
  };
  Order.Information.showTotalItems();
  Order.Information.closeResultSearch();
  // Mỗi lần thêm 1 sản phẩm sẽ thực hiện sẽ tăng line lên 1
  Order.Information.lineCount +=1;
  
//  $('table#listItem').ad
}
// Thay đổi số lượng sản phẩm
Order.Information.changeQuantity = function(e,price,line){
  // Thay đổi lại giá trị quantity
  Order.Information.LineItem[line].quantity = e;
  // Điều chỉnh lại input hidden name = productId[];
  $('.line_item_'+line+' input#product_id_'+line).val(e);
  var Result = money(price * e, AMOUNT_NO_DECIMALS_WITH_COMMA_SEPARATOR);
  $('.line_item_'+line+' #totalItem ').text(Result+'₫');
  Order.Information.showTotalItems();
  
}
Order.FormatPrice = function(e,price){
  var Result = money(price * e, AMOUNT_NO_DECIMALS_WITH_COMMA_SEPARATOR);
  return Result;
}

var timeout;



//
//$('#coupon-product').delegate('.fa-minus-circle', 'click', function() {
//  $(this).parent().remove();
//});
Order.viewShipping = function(){
  var xHtml = '<li><strong>Họ đệm</strong> : '+Order.Customer.ItemSelect.fullname+'</li> ';
     xHtml += '<li><strong>Số điện thoại</strong> : '+Order.Customer.ItemSelect.telephone+'</li> ';
     xHtml += '<li><strong>Địa chỉ</strong> : '+Order.Customer.ItemSelect.address+'</li> ';
     xHtml += '<li><strong>Tỉnh/Thành phố</strong> : '+Order.Customer.ItemSelect.city+'</li> ';
     xHtml += '<li><strong>Quận huyện</strong> : '+Order.Customer.ItemSelect.district+'</li> ';
     xHtml += '<li><strong>Quốc Gia</strong> : Việt Nam</li> ';
     $('#profile ul.shippingClass').html(xHtml);
     Order.getInfoShipping();
    // $('#shipping_options input[name=lastname]').val(Order.Customer.ItemSelect.lastname);
    // $('#shipping_options input[name=firstname]').val(Order.Customer.ItemSelect.firstname);
    // $('#shipping_options input[name=telephone]').val(Order.Customer.ItemSelect.telephone);
    // $('#shipping_options input[name=address]').val(Order.Customer.ItemSelect.address);
    // $('#shipping_options input[name=lastname]').val(Order.Customer.ItemSelect.lastname);
    // $('#shipping_options input[name=lastname]').val(Order.Customer.ItemSelect.lastname);
}
Order.getInfoShipping = function(){
  $.ajax({
    url: '/admin/orders/updateShipping',
    type: "POST",
    data: Order.Customer.ItemSelect,
    success : function(response){
      console.log(response);
      $('#contentShipping').html(response);
    }
  })
}

Order.updateShipping = function(){
  $('#UpdateShipping').modal('show');
}
Order.viewPayment = function(){
  console.log(Order.Customer.ItemSelect);
  var xHtml = '<li><strong>Họ đệm</strong> : '+Order.Customer.ItemSelect.fullname+'</li> ';
     xHtml += '<li><strong>Số điện thoại</strong> : '+Order.Customer.ItemSelect.telephone+'</li> ';
     xHtml += '<li><strong>Địa chỉ</strong> : '+Order.Customer.ItemSelect.address+'</li> ';
     xHtml += '<li><strong>Tỉnh/Thành phố</strong> : '+Order.Customer.ItemSelect.city+'</li> ';
     xHtml += '<li><strong>Quận huyện</strong> : '+Order.Customer.ItemSelect.district+'</li> ';
     xHtml += '<li><strong>Quốc Gia</strong> : Việt Nam</li> ';
 
}
Order.Customer.selectCustomer = function(infoItem){
  Order.Customer.ItemSelect = infoItem;
  Order.Customer.ShowCustomerSelect();
  $('.textbox-advancesearch').click();
  // trước khi thêm form edit Customer thì cần thực hiện xóa hết customer cũ
  Order.viewShipping();
  Order.Customer.removeModalEdit();
}
Order.Customer.removeCustomers = function(){
  $('.showCustomerDebt').remove();
  // trước khi thêm form edit Customer thì cần thực hiện xóa hết customer cũ
  Order.Customer.removeModalEdit();
}
Order.Customer.editCustomer = function(){
  $.ajax({
        url: '/admin/customers/showInfo',
        type: "POST",
        data: {id:Order.Customer.ItemSelect.customer_id},
        success: function (response) {
          // trước khi thêm form edit Customer thì cần thực hiện xóa hết customer cũ
          Order.Customer.removeModalEdit();
          // Sau đó mới thêm lại form
          $('.page-body').append(response);
          // Hiển thị form
          $('#editCustomer').modal('show');
          //$('#shipping_options').('show');
        }
    });
}
Order.Customer.removeModalEdit = function(){
  $('#editCustomer').remove();
}
Order.Customer.updateCustomer = function(){
  var dataUpdate = $('#editCustomer form').serialize();
  $.ajax({
        url: '/admin/customers/updateAjax',
        type: "POST",
        data: dataUpdate,
        dataType: 'json',
        success: function (response) {
          showMessages(response.message);
          console.log(response)
          $('#editCustomer').modal('hide');
          // Load lại list Customer
          Order.Customer.getCustomer('');
          //$('#shipping_options').('show');
          // Show lại Info customer
          Order.Customer.ItemSelect = response.infoItem;
          Order.Customer.ShowCustomerSelect();
          Order.viewShipping();


        }
    });
}
Order.Customer.ShowCustomerSelect = function(){
   $('.infoCustomer').html('');
   var xHtmlInfo = '<li class="txtB posR mb10 showCustomerDebt">';
        xHtmlInfo += '<a class="icon del" onclick="Order.Customer.removeCustomers()" title="Bỏ chọn khách hàng"><i class="fa fa-times"></i>';
        xHtmlInfo += '</a><a onclick="Order.Customer.editCustomer()" class="txtBlue">'+Order.Customer.ItemSelect.fullname+'</a>';
        xHtmlInfo += '<span class="split"></span><i class="fa fa-mobile-phone"></i>';
        xHtmlInfo += '<input type="hidden" value="'+Order.Customer.ItemSelect.customer_id+'" name="customer_id">';
        xHtmlInfo += '<span class="veaM">'+Order.Customer.ItemSelect.telephone+'</span></li>';
        $('.infoCustomer').html(xHtmlInfo);
        $('#addCustomer').modal('hide');      
}
Order.Customer.QuickAdd = function(urlAction){
        $.ajax({
            url: urlAction,
            type: "POST",
            data: Order.Customer.Data,
            dataType: 'json',

            success: function (data) {
              if(data.status == true){
                Order.Customer.ItemSelect = data.infoItem;
                Order.Customer.ShowCustomerSelect();
                $('.textbox-advancesearch').click();
                showMessages(data.message);
              }else{
                showMessages(data.message);
              }
            }
        });
}

Order.Customer.getCustomer = function(QueryString = ''){
        $.ajax({
            url: '/admin/customers/GetCustomer',
            type: "GET",
            data: {Query:QueryString},
            success: function (response) {
               $('.list-search-data').html(response);
            }

        });
}
function convertDecimalToMoneyString(money, type) {
    if (type === AMOUNT) {
        return money.formatMoney(2, '.', ',');
    }
    else if (type === AMOUNT_NO_DECIMAL) {
        return money.formatMoney(0, '.', ',');
    }
    else if (type === AMOUNT_NO_DECIMALS_WITH_COMMA_SEPARATOR) {
        return money.formatMoney(0, ',', '.');
    }
}

//HĂ m format string nhÆ° C# sá»­ dá»¥ng "Test format {0}".format("abc")
if (!String.prototype.format) {
  String.prototype.format = function () {
      var args = arguments;
      return this.replace(/{(\d+)}/g, function (match, number) {
          return typeof args[number] != 'undefined'
              ? args[number]
              : match
          ;
      });
  };
}

if (!Number.prototype.formatMoney) {
  Number.prototype.formatMoney = function (c, d, t) {
      var n = this,
          c = isNaN(c = Math.abs(c)) ? 2 : c,
          d = d == undefined ? "." : d,
          t = t == undefined ? "," : t,
          s = n < 0 ? "-" : "",
          i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "",
          j = (j = i.length) > 3 ? j % 3 : 0;
      return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
  };
}
var AMOUNT_NO_DECIMALS_WITH_COMMA_SEPARATOR = "{{amount_no_decimals_with_comma_separator}}";
var AMOUNT = "{{amount}}";
var AMOUNT_NO_DECIMAL = "{{amount_no_decimals}}";
function money(money, moneyFormat) {
    if (moneyFormat.indexOf(AMOUNT) > -1) {
        var moneyFormatString = moneyFormat.replace(AMOUNT, "{0}");
        var moneyText = convertDecimalToMoneyString(money, AMOUNT);
        return moneyFormatString.format(moneyText);
    }
    else if (moneyFormat.indexOf(AMOUNT_NO_DECIMAL) > -1) {
        var moneyFormatString = moneyFormat.replace(AMOUNT_NO_DECIMAL, "{0}");
        var moneyText = convertDecimalToMoneyString(money, AMOUNT_NO_DECIMAL);
        return moneyFormatString.format(moneyText);
    }
    else if (moneyFormat.indexOf(AMOUNT_NO_DECIMALS_WITH_COMMA_SEPARATOR) > -1) {
        var moneyFormatString = moneyFormat.replace(AMOUNT_NO_DECIMALS_WITH_COMMA_SEPARATOR, "{0}");
        var moneyText = convertDecimalToMoneyString(money, AMOUNT_NO_DECIMALS_WITH_COMMA_SEPARATOR);
        return moneyFormatString.format(moneyText);
    }
}




$("ul.alert.alert-success.fade.in").fadeOut(3000);
$("ul.alert.alert-danger").fadeOut(5000);
$(document).ready(function(){
  $('.date-picker').datepicker();
  
})
$(".select2").select2();

///////// Upload Image Jquery//////////
  var ImageObj = {};
  // Giá trị dùng để đếm thành phần đã được update
  ImageObj.lastIndexImage = null;
  // Phương thức in ra hình ảnh sản phẩm preview
  ImageObj.generateAddedImage = function (src, alt, productImageId) {
            var linkImagePreview = src;
            var linkImageEdit = src;    
        return '<li class="product-photo-item" id="product-image-' + productImageId + '"><input type="hidden" name="image[]" value="'+src+'">' +
                    '<div class="product-image next-media-square-aspect-ratio">' +
                        '<img class="media-image image-align-middle" src="' + linkImagePreview + '" alt="' + alt + '" />' +
                        '<div class="product-photo-hover-overlay drag">' +
                            '<div class="image-option-tools">' +
                                '<a class="image-action tooltip tooltip-bottom" href="javascript:void(0);" bind-event-click="previewImage(&quot;' + linkImagePreview + '&quot;)"><i class="fa fa-eye"></i></a>' +
                                '<a class="image-action tooltip tooltip-bottom" href="javascript:void(0)" bind-event-click="launchAviary(&quot;' + productImageId + '&quot;, &quot;' + src + '&quot;)"><i class="fa fa-pencil"></i></a>' +
                                '<a class="image-action tooltip tooltip-bottom" bind-event-click="showEditImageAlt(&quot;' + linkImageEdit + '&quot;,' + productImageId + ',' + this.id + ')" href="javascript:void(0);"><span>ALT</span></a>' +
                                '<a class="image-action tooltip tooltip-bottom" onclick="ImageObj.showDeleteProductImageModal(0,' + productImageId + ',\''+linkImagePreview+'\')" href="javascript:void(0);"><i class="fa fa-trash-o"></i></a>' +
                            '</div>' +
                        '</div><input type="hidden" name="productImageIds" value="' + productImageId + '" /></div></li>';
    }

    function preview_image(input,id) {
       $('#product-images').append('<li class="product-photo-item ui-sortable-handle" id="product-image-'+id+'"><input type="hidden" name="image[]" value="'+input+'"><div class="product-image next-media-square-aspect-ratio"> <img class="media-image image-align-middle" src="' + input + '"> <div class="product-photo-hover-overlay drag"> <div class="image-option-tools"> <a class="image-action tooltip tooltip-bottom" onclick="showDeleteProductImageModal(0,\''+id+'\',\''+input+'\')" > <i class="fa fa-trash-o"></i> </a> </div></div></div></li>');
    }
    $('input[name=image]').change(function(){
        var dataArr = this;
        UpdateToPreview(dataArr);
    })

    $('input[name=\'albumImages[]\']').on('change',function(){
        var dataArr = this;
        var data =  ImageObj.UpdateToPreview(dataArr);
    });
    // Thực hiện update ảnh
    ImageObj.successUpdate = function(){
      console.log('Update');
    }
    ImageObj.UpdateToPreview = function (dataArr){
    {
        ImageObj.lastPosition = ImageObj.lastIndexImage;
        ImageObj.uploadImages = [];
        var fileItem = dataArr.files;
            var formData = new FormData();
            var totalFiles = fileItem.length;
            if (totalFiles <= 0) {
                return;
            }
            if (ImageObj.lastIndexImage == null) {
              ImageObj.lastIndexImage = 0;
            }
            
            // Set file upload
            for (var i = 0; i < totalFiles; i++) {
              var file = document.getElementById("fileUpload").files[i];
                var size = file.size;
              var uploadImage = {};
                uploadImage.File = file;
                uploadImage.Position = ImageObj.lastPosition;
                uploadImage.IdImageElement = "product-image-" + ImageObj.lastPosition;
                ImageObj.uploadImages.push(uploadImage);
            }

            for (var i = 0; i < totalFiles; i++) {
              
              formData.append("mediaImages[]", file);
            }
            ImageObj.formData =  formData
//            for (var i = 0; i < totalFiles; i++) {
//              var file = document.getElementById("fileUpload").files[i];
//                var FR = new FileReader();
//                FR.onload = function (e) {
//          console.log(ImageObj.lastIndexImage);
//                    var addImage = ImageObj.generateAddedImage(e.target.result, "", ImageObj.lastIndexImage);
//                    var another = $(addImage);
//                    $('#product-images').append(another);
//                    ImageObj.lastIndexImage++;
//                };
//                FR.readAsDataURL(file);
//            }
            // Upload Image
            for (var i = 0; i < totalFiles; i++) {
               var file = ImageObj.uploadImages[i]['File'];
               formData.append("mediaImages", file);
               $.ajax({
                   type: "POST",
                   url: '/admin/products/upload',
                   data: formData,
                   contentType: false,
                   processData: false,
                   success: function (response) {
                   var addImage = ImageObj.generateAddedImage(response, "", ImageObj.lastIndexImage);
                     var another = $(addImage);
                     $('#product-images').append(another);
                     ImageObj.lastIndexImage++;
                   console.log(response);
                   },
                   error: function (error) {
                    showMessages('Xóa hình ảnh không thành công');
                   }
               });
           }

        }
    }
    ImageObj.showDeleteProductImageModal = function showDeleteProductImageModal(productId, productImageId,imgLink) {
        //alert(123);
        $('button#deleteProductImageModal').click();
        
        $('.form-delete-product-image input[name="productId"]').val(productId);
        $('.form-delete-product-image input[name="productImageId"]').val(productImageId);
        $('.form-delete-product-image input[name="imgLink"]').val(imgLink);
    }
    function deleteProductImage(productId,productImageId,productImageId){
        var prdId =  $('.form-delete-product-image input[name="productId"]').val();
        var prdImgId = $('.form-delete-product-image input[name="productImageId"]').val();
        var imgLink = $('.form-delete-product-image input[name="imgLink"]').val();
       
      $.ajax({
            type: "POST",
            url: '/admin/products/deleteImages',
            data: {
                prdId: prdId,
                prdImgId : prdImgId,
                imgLink  : imgLink
            },
            success: function (data) {
                showMessages(data);
                $('li#product-image-'+prdImgId+'').remove();
                $('.close-modal').click();
            },
            
        });
        
    }

    function showMessages(messages){
        $('.ajax-notification').addClass('is-visible');
        $('span.ajax-notification-message').text(messages);
        setTimeout(function(){
            $('.ajax-notification').removeClass('is-visible');
        },2000);
        $('.close-notification').click(function(){
            $('.ajax-notification').removeClass('is-visible');
        });
    }
///////// End upload Image Jquery//////////
    // Hành động số lượng lớn
   
    var BulkActions = {};
    BulkActions.selectedItems = [];
   // // selected multiple items.
    BulkActions.addOrRemoveAllBulkActionItems = function (eleAllCheckBox) {

        var allBulkActionItems = $("#frmBulkActions input[name='ids[]']");
        if (allBulkActionItems != null && allBulkActionItems.length > 0) {
            allBulkActionItems.remove();
        }
        var allChecked = $('#checkAll').prop('checked');
        if (allChecked) {
          
            var selectedBulkActionItems = 0;
            var that = this;
            $('.bulk-action-context').find('.bulk-action-item').each(function () {
                var $this = $(this);
                $this.prop('checked', true);
                var bulkActionItemId = $this.val();
                that.selectedItems.push(bulkActionItemId);
                var newBulkActionItem = document.createElement('input');
                newBulkActionItem.type = "hidden";
                newBulkActionItem.name = "ids[]";
                newBulkActionItem.value = bulkActionItemId;
                newBulkActionItem.id = "bulk-action-item-" + bulkActionItemId;
                document.getElementById("frmBulkActions").appendChild(newBulkActionItem);
                selectedBulkActionItems++;
            });
            this.showBulkActionItemsCount(selectedBulkActionItems);

        } else {
            $('.bulk-action-context').find('.bulk-action-item').each(function () {
                var $this = $(this);
                $this.prop('checked', false);

            });
            this.showBulkActionItemsCount(0);
        }
    }

    
    // selected one item.
    BulkActions.addOrRemoveBulkActionItem = function (bulkActionItemId, eleCheckBox) {
        bulkActionItemId = bulkActionItemId.toString();

        var checked = eleCheckBox.checked;
        var selectedBulkActionItems = $('.bulk-action-items-count').attr("selected-bulk-action-items");
        console.log(this.selectedItems);
        if (checked) {
            this.selectedItems.push(bulkActionItemId);
            var newBulkActionItem = document.createElement('input');
            newBulkActionItem.type = "hidden";
            newBulkActionItem.name = "ids[]";
            newBulkActionItem.value = bulkActionItemId;
            newBulkActionItem.id = "bulk-action-item-" + bulkActionItemId;
            document.getElementById("frmBulkActions").appendChild(newBulkActionItem);
            selectedBulkActionItems++;
        } else {
            var index = this.selectedItems.indexOf(bulkActionItemId);
            if (index > -1) {
                this.selectedItems.splice(index, 1);
            }
            var removeBulkActionItem = document.getElementById("bulk-action-item-" + bulkActionItemId);
            if (removeBulkActionItem != null) {
                removeBulkActionItem.parentNode.removeChild(removeBulkActionItem);
                selectedBulkActionItems--;
            }
        }

        this.showBulkActionItemsCount(selectedBulkActionItems);
    }
    // Show action and numbers on the selected inputs - Hiển thị hành động và số lượng input được chọn
    BulkActions.showBulkActionItemsCount = function(count){
      countCheckOn = $('input:checked').length;
      if(countCheckOn > 0){
            $('.bulk-actions').removeClass('hide');
        }else{
             $('.bulk-actions').addClass('hide');
        }
        $('.display-bulk-action-items-count').html(countCheckOn);
    }
    // Change the status value of 1
    BulkActions.publishItems  = function (urlBulkActionUnPublish) {
      var data = $("#frmBulkActions").serialize();
      var newBulkActionItem = document.createElement('input');
        newBulkActionItem.type = "hidden";
        newBulkActionItem.name = "success";
        newBulkActionItem.value = 1;
        document.getElementById("frmBulkActions").appendChild(newBulkActionItem);
        $.ajax({
            url: urlBulkActionUnPublish,
            type: "POST",
            data: $("#frmBulkActions").serialize(),
            success: function (data) {
              showMessages(data);
              setTimeout(function(){
                window.location.href = window.location.href 
              },2300);
            }
        });
    }
    // Change the status value of 0
    BulkActions.UnpublishItems  = function (urlBulkActionUnPublish) {
      // Add Input value status change
      var data = $("#frmBulkActions").serialize();
      var newBulkActionItem = document.createElement('input');
        newBulkActionItem.type = "hidden";
        newBulkActionItem.name = "success";
        newBulkActionItem.value = 0;
        document.getElementById("frmBulkActions").appendChild(newBulkActionItem);
        $.ajax({
            url: urlBulkActionUnPublish,
            type: "POST",
            data: $("#frmBulkActions").serialize(),
            success: function (data) {
              showMessages(data);
              setTimeout(function(){
                window.location.href = window.location.href 
              },2300);
            }
        });
    }
    // Show Modal Delete Product
    BulkActions.showModalDelete = function(){
      $('#deleteProductModal').modal({
          show: 'true'
      }); 
    }
    // Delete multiple products
    BulkActions.deleteItems  = function (urlBulkAction) {
        $.ajax({
            url: urlBulkAction,
            type: "POST",
            data: $("#frmBulkActions").serialize(),
            success: function (data) {
              showMessages(data);
              setTimeout(function(){
                window.location.href = window.location.href 
              },1000);
            }
        });
    }
    // FilterAndSavedSearch indexAction 
    var FilterAndSavedSearch  = {};
    FilterAndSavedSearch.onInit = function(){
      FilterAndSavedSearch.formFilter = $('#filterActions');
      FilterAndSavedSearch.url = $('#filterActions').attr('action');
    }
    FilterAndSavedSearch.submitFilter = function(){
      var formData = FilterAndSavedSearch.formFilter;
      // Filter General
      // Query - Keyword
      FilterAndSavedSearch.Query = $('input[name=\'Query\']').val();
      FilterAndSavedSearch.url += '?Query=' + encodeURIComponent(FilterAndSavedSearch.Query);
      // Status
      FilterAndSavedSearch.status  =  $('select[name=\'filter_status\']').val();
      if (FilterAndSavedSearch.status != '') {
        FilterAndSavedSearch.url += '&filter_status=' + encodeURIComponent(FilterAndSavedSearch.status);
      }
      // End Filter General
      // Create Filter Products
      FilterAndSavedSearch.products = {};
      // Conllection
      FilterAndSavedSearch.products.filter_collection  =  $('select[name=\'filter_collection\']').val();
      if (FilterAndSavedSearch.products.filter_collection != '') {
        FilterAndSavedSearch.url += '&filter_collection=' + encodeURIComponent(FilterAndSavedSearch.products.filter_collection);
      }
      // filter_group_product
      FilterAndSavedSearch.products.filter_group_product  =  $('select[name=\'filter_group_product\']').val();
      if (FilterAndSavedSearch.products.filter_group_product != '') {
        FilterAndSavedSearch.url += '&filter_group_product=' + encodeURIComponent(FilterAndSavedSearch.products.filter_group_product);
      }
      // filter_vendor
      FilterAndSavedSearch.products.filter_vendor  =  $('select[name=\'filter_vendor\']').val();
      if (FilterAndSavedSearch.products.filter_vendor != '') {
        FilterAndSavedSearch.url += '&filter_vendor=' + encodeURIComponent(FilterAndSavedSearch.products.filter_vendor);
      }
      location  = FilterAndSavedSearch.url;
      console.log(FilterAndSavedSearch.url);
    }
    FilterAndSavedSearch.onInit();
    
    
    var Discount = {};
    Discount.onInit = function(){
      $('select[name=apply_promotion]').on('change',function(){
        var boxShow  = $(this).val();
        var showElement = '#apply_promotion #'+boxShow;
        // Ẩn tất cả các box
        $('#apply_promotion .form-group').addClass('hide');
        // Hiện box đã chọn
        $(showElement).removeClass('hide');
      })
    }
    Discount.generateCode = function () {
        var t, e, n, o, i, code;
        for (t = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ", code = "", i = [], e = o = 8; o >= 1; e = --o) {
            n = Math.floor(Math.random() * t.length);
            i.push(code += t.substring(n, n + 1));
        }
        $("input[name=code]").val(code);
    }
    $('input[name=never_expire]').on('click',function(){
      var isCheck = $(this).is(':checked');
      var inputDateEnd = $('input[name=date_end]');
      (isCheck == true ) ? inputDateEnd.attr('disabled','disabled') : inputDateEnd.attr('disabled',false) ;
    })
    Discount.onInit();
    /* ]]> */
