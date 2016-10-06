CKEDITOR.dialog.add('imagebrowseDialog', function (editor) {
    return {
        title: 'Chọn ảnh',
        minWidth: 580,
        minHeight: 300,
        contents: [
            {
                id: 'tab-products',
                label: 'Sản phẩm',
                elements: [
                    {
                        type: 'text',
                        id: 'selected-product-image',
                        style: 'display: none',
                        className: 'selected-product-image'
                    },
                    {
                        type: 'text',
                        id: 'selected-thumb-type-product-image',
                        style: 'display: none',
                        className: 'selected-thumb-type-product-image'
                    },
                    {
                        type: 'html',
                        html: '<a href="javascript: void(0);" class="cke-product-images"></a>'
                    }
                ]
            },
            {
                id: 'tab-media-files',
                label: 'File',
                elements: [
                    {
                        type: 'text',
                        id: 'selected-media-file',
                        style: 'display: none',
                        className: 'selected-media-file'
                    },
                    {
                        type: 'text',
                        id: 'selected-thumb-type-media-file',
                        style: 'display: none',
                        className: 'selected-thumb-type-media-file'
                    },
                    {
                        type: 'html',
                        id: 'media-files',
                        html: '<div href="javascript: void(0);" class="cke-all-images"></div>'
                    }
                ]
            },
            {
                id: 'tab-image-url',
                label: "Đường dẫn ảnh",
                elements: [
                    {
                        type: 'text',
                        id: 'image-url',
                        label: "Đường dẫn ảnh"
                    }
                ]
            },
            {
                id: 'tab-image-upload',
                label: "Tải lên",
                elements: [
                    {
                        type: 'file',
                        id: 'image-file'
                    },
                    {
                        type: 'select',
                        id: 'thumb-type',
                        className: 'thumb-type',
                        label: 'Kích thước ảnh',
                        labelStyle: 'font-weight: bold; margin-top: 15px;',
                        items: [
                            ['Original', 'original'],
                            ['Pico (16x16)', 'pico'],
                            ['Icon (32x32)', 'icon'],
                            ['Thumb (50x50)', 'thumb'],
                            ['Small (100x100)', 'small'],
                            ['Compact (160x160)', 'compact'],
                            ['Medium (240x240)', 'medium'],
                            ['Large (480x480)', 'large'],
                            ['Grande (600x600)', 'grande'],
                            ['1024x1024 (1024x1024)', '1024x1024'],
                            ['2048x2048 (2048x2048)', '2048x2048'],
                        ],
                        'default': 'original'
                    }
                ]
            }
        ],
        onShow: function () {
            openChooseImageDialog();
        },
        onOk: function () {
            var dialog = this;
            var CurrObj = CKEDITOR.dialog.getCurrent();
            var currTab = CurrObj.definition.dialog._.currentTabId;

            var image = editor.document.createElement('img');

            if (currTab == "tab-media-files") {
                var listSrc = this.getValueOf('tab-media-files', 'selected-media-file');
                
                var thumbType = this.getValueOf('tab-media-files', 'selected-thumb-type-media-file');
                if (thumbType == "") {
                    thumbType = "original";
                }

                var sources = listSrc.split(",");
                for (var i = 0; i < sources.length; i++) {
                    var src = changeSrcByThumbType(sources[i]);
                    if (src != "") {
                        var img = editor.document.createElement('img');
                        img.setAttribute('src', src);
                        editor.insertElement(img);
                    }
                }

            } else if (currTab == "tab-products") {
                var listSrc = this.getValueOf('tab-products', 'selected-product-image');
                var thumbType = this.getValueOf('tab-products', 'selected-thumb-type-product-image');
                if (thumbType == "") {
                    thumbType = "original";
                }
                var sources = listSrc.split(",");
                for (var i = 0; i < sources.length; i++) {
                    var src = changeSrcByThumbType(sources[i]);
                    if (src != "") {
                        var img = editor.document.createElement('img');
                        img.setAttribute('src', src);
                        editor.insertElement(img);
                    }
                }

            } else if (currTab == "tab-image-url") {
                var src = this.getValueOf('tab-image-url', 'image-url');
                if (src != "") {
                    image.setAttribute('src', src);
                    editor.insertElement(image);
                }
            } else if (currTab == "tab-image-upload") {
                var thumbType = this.getValueOf('tab-image-upload', 'thumb-type');
                var fileElement = this.getContentElement('tab-image-upload', 'image-file').getInputElement().$;

                if (fileElement.files.length > 0) {
                    var file = fileElement.files[0];
                    if (file.size > 1048576) {
                        alert("Kích thước file tối đa được upload là 1MB.");
                        return false;
                    }
                    if (!file.name.toLowerCase().match(/\.(jpg|jpeg|png|gif)$/)) {
                        alert("File upload không đúng định dạng.");
                        return false;
                    }

                    var formData = new FormData();
                    console.log(formData);
                    formData.append("mediaImages", file);
                    $.ajax({
                        type: "POST",
                        url: '/admin/products/upload',
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (response) {
                            image.setAttribute('src', response);
                            editor.insertElement(image);
                            CKEDITOR.dialog.getCurrent().hide();
                        },
                        error: function (error) {
                            alert("Đã có lỗi xảy ra. Tải lên thất bại.")
                        }
                    });
                }

                return false;
            }
        }
    };
});
// BEGIN: CKEditor
CKEDITOR.timestamp = '21102016';

function initCkEditor(obj) {
    obj.ckeditor();
}

function openChooseImageDialog() {
    $.ajax({
        url: '/admin/products/showMediaFiles',
        success: function (data) {
            $(".cke-all-images").html(data);
        }
    });
    $.ajax({
        url: '/admin/products/showMediaFiles',
        success: function (data) {
            $(".cke-product-images").html(data);
        }
    });
}

function chooseImage(obj) {
    var selectedSrc = $(".selected-media-file").find("input").val();
    var src = $(obj).children("img").attr("src");
    if ($(obj).hasClass("chosen-image")) {
        $(obj).removeClass("chosen-image");
        if (selectedSrc != "" && !selectedSrc.endsWith(",")) {
            selectedSrc = selectedSrc + ",";
        }
        selectedSrc = selectedSrc.replace(src + ",", "");
    } else {
        $(obj).addClass("chosen-image");
        selectedSrc += selectedSrc == "" ? src : "," + src;
    }
    if (selectedSrc.endsWith(",")) {
        selectedSrc = selectedSrc.substring(0, selectedSrc.length - 1);
    }
    $(".selected-media-file").find("input").val(selectedSrc);
}

function chooseProductImage(obj) {
    var selectedSrc = $(".selected-product-image").find("input").val();
    var src = $(obj).children("img").attr("src");
    if ($(obj).hasClass("chosen-image")) {
        $(obj).removeClass("chosen-image");
        if (selectedSrc != "" && !selectedSrc.endsWith(",")) {
            selectedSrc = selectedSrc + ",";
        }
        selectedSrc = selectedSrc.replace(src + ",", "");
    } else {
        $(obj).addClass("chosen-image");
        selectedSrc += selectedSrc == "" ? src : "," + src;
    }
    if (selectedSrc.endsWith(",")) {
        selectedSrc = selectedSrc.substring(0, selectedSrc.length - 1);
    }
    $(".selected-product-image").find("input").val(selectedSrc);
}

function changeProductThumbType(obj) {
    $(".selected-thumb-type-product-image").find("input").val($(obj).val());
}

function changeThumbType(obj) {
    $(".selected-thumb-type-media-file").find("input").val($(obj).val());
}

function changeSrcByThumbType(src, thumbType) {
    // src Thumb 
    // http://vndgroup-zf2.com/public/media/products/images/1_1.jpg
    // http://vndgroup-zf2.com/public/media/products/thumb/small/100.100_1_1.jpg
    src = src.replace("/public/media/products/thumb/small/100.100_", "/public/media/products/images/");
    return src;
}
function getOriginalImages(src,thumbType) {
    
}