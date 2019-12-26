$(document).ready(function(){
    $('#accordion').dcAccordion({
        eventType: 'click',
        autoClose: false,
        //	saveState: false,
        disableLink: false,
        showCount: true,
        speed: 'slow'
    });

    $(document).on('click', '.get_url', function(e){
        e.preventDefault();

       var href = $(this).attr("href"); // ссылка на которую нажали
        var id = $(this).attr("id"); // id ссылки на которую нажали
        var current_url = getParams().category; //id текущей ссылки(на которой пользователь находится)

if(current_url!=id) {
    history.pushState(null, null, href);
    getContent(getParams().category, getParams().sort);
   // getBredcrumps(getParams().category);
}
    });
    getContent(getParams().category,getParams().sort);
    //getBredcrumps(getParams().category);
    if(getParams().sort){

        $("#sort_by option[value="+getParams().sort+"]").attr("selected","selected");

    }else {
        $("#sort_by option[value="+''+"]").attr("selected","selected");

    }

    $(document).on('change', '#sort_by', function(e){
        e.preventDefault();
        var val = $("#sort_by").val();
        const url = new URL(document.location);
        url.searchParams.set('sort', val);
        history.pushState(null, null, url.href);
        // getContent(getParams().category,getParams().sort);
    });
});


function getContent(arg, sort_by) {
    if(!getParams().sort) {
         $("#sort_by").val("");
    }
    $.ajax({
        url: 'ajax_contents.php',
        data: {arg,sort_by},
        type: 'post',
        dataType: 'JSON',
        success: function (data) {

                $.each(data, function (key, data) {

                    if (key == 0) {
                        if (data.answer != 'no') {
                            var tr_str2 = '';
                            $.each(data, function (index, value) {

                                tr_str2 += "<br />" +
                                    "<a class='get_url' href=?category=" + value['id_cat'] + ">" + value['title_cat'] + "</a>";
                                tr_str2 += '</div>';

                            });
                        } else {
                            tr_str2 = "";
                        }
                        $(".cat_content").html(tr_str2);
                    }
                    if (key == 1) {
                        var tr_str = '';
                        if (data.answer != 'no') {
                            $.each(data, function (index, value) {

                                tr_str +=
                                    "<div class='goods-card' data-new='" + value['date'] + "' data-price='" + value['price'] + "' data-Alfavit='" + value['title'] + "'>" +
                                    "<div>" +
                                    "<h1>" + value['title'] + "</h1>" +
                                    "</div>" +
                                    "<div>" +
                                    "<p>" + value['price'] + " грн</p>" +
                                    "<p>" + value['date'] + "</p>" +
                                    "</div>" +
                                    "<div class='col text-center'>" +
                                    "<a href='#' class='btn btn-lg btn-success' data-toggle='modal' id='buy' value='" + value['id'] + "' data-target='#addModal'>Купить</a>" +
                                    "</div>";

                                tr_str += "</div>";

                            });

                        } else {
                        tr_str = "<div>" +
                            "<p>в этой категории товаров нет</p>";
                        tr_str += "</div>";
                    }
                    $(".content").html(tr_str);

                }
                    if (key == 2) {
                        var tr_str = '';
                       if(!getParams().category) {
                            tr_str += "<a class='get_url' href='" + path + "'>Главная</a> / Каталог";
                            tr_str += '';
                        }else {
                            tr_str += "<a class='get_url' href='" + path + "'>Главная</a> / ";
                            tr_str += '';
                        }
                        $.each(data, function (index, value) {

                            tr_str +=
                                "<a class='get_url' id='bredId-"+index+"' href=?category="+index+">" + value + "</a> / ";
                            tr_str += '';

                        });

                        $(".breadcrumbs123").html(tr_str);

                        //замена тега <a> на <span> текущей ссылки в навигационной цепочке
                        $( "#bredId-"+getParams().category ).replaceWith(function(index, oldHTML){
                            return $("<span>").html(oldHTML);
                        });


                    }

                });

            }
    });
}
$(document).on('click', '#buy', function(e){
    e.preventDefault();
    var val = $(this).attr("value");
    $.ajax({
        url: 'get_one_product.php',
        data: {val},
        type: 'post',
        dataType: 'JSON',
        success: function (response) {
            // alert(response.title);
            $('#title').text(response.title);
            $('#price').text(response.price);
            $('#date').text(response.date);

        }
    });

});

document.addEventListener('DOMContentLoaded', function() {
    const SORT_SELECTOR =  document.getElementById('sort_by');
    SORT_SELECTOR.addEventListener('input', sortBy);
});

function getParams() {
    var params = window
        .location
        .search
        .replace('?','')
        .split('&')
        .reduce(
            function(p,e){
                var a = e.split('=');
                p[ decodeURIComponent(a[0])] = decodeURIComponent(a[1]);
                return p;
            },
            {}
        );
    return params;
}

// массивы с данными для сортировки
//массив для типа данных, 'sort-asc',  'sort-new', 'sort-Alfavit' - value из select
var decode3 = {
    'sort-asc':  'number',
    'sort-new': 'string',
    'sort-Alfavit': 'string'
};

//массив с данными, 'sort-asc',  'sort-new', 'sort-Alfavit' - value из select
var decode5 = {
    'sort-asc': 'data-price',
    'sort-new': 'data-new',
    'sort-Alfavit': 'data-Alfavit'
};

function massiv(arg,paremetr) { //ф-нция для сравнения элементов массива из value из select
    // arg - входящий массив decode3 или decode5
    //  paremetr - value из select
    var eurocode = paremetr;
    var resultDC5 = '';
    var tmpString = '';
    for (i = 0; i < eurocode.length; i++) {
        tmpString += eurocode[i];
        for (var key in arg) {
            if (tmpString.indexOf(key) + 1) {
                resultDC5 += arg[key];
                tmpString = "";
                break;
            };
        };
    }
    return resultDC5;
}
function sortBy(event){  //запуск сортировки
    if(this.value){// выбранное value из select
        sortList(massiv(decode5,this.value),massiv(decode3,this.value));
    }
}
function sortList(sortType, dataType) { //ф-ция сортировки
    // sortType - по какому критерию сортировать
    // dataType типа данных для сортировки number/string ...
    let items = document.querySelector('.content');
    for (let i = 0; i < items.children.length - 1; i++) {
        for (let j = i; j < items.children.length; j++) {
            if(dataType == 'number') {
                if (+items.children[i].getAttribute(sortType) > +items.children[j].getAttribute(sortType)) {

                    let replacedNode = items.replaceChild(items.children[j], items.children[i]);
                    insertAfter(replacedNode, items.children[i]);
                }
            }
            if(dataType == 'string' && sortType=='data-Alfavit') {
                if (items.children[i].getAttribute(sortType) > items.children[j].getAttribute(sortType)) {

                    let replacedNode = items.replaceChild(items.children[j], items.children[i]);
                    insertAfter(replacedNode, items.children[i]);
                }
            }
            if(dataType == 'string' && sortType=='data-new') {
                if (items.children[i].getAttribute(sortType) < items.children[j].getAttribute(sortType)) {

                    let replacedNode = items.replaceChild(items.children[j], items.children[i]);
                    insertAfter(replacedNode, items.children[i]);
                }
            }
        }
    }
}
function insertAfter(elem, refElem) {
    return refElem.parentNode.insertBefore(elem, refElem.nextSibling);
}