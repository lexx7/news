/**
 * Created by lex on 06.06.2016.
 */

$(function () {
    Site.init();
    Site.actions();
});

Site = {
    init: function () {
        var limit = this.getParamHref('limit');
        if (limit !== null) $('#limit-news').val(limit);
    },
    actions: function () {
        $(document).on('change', '#limit-news', function () {
            var limitNews = $(this).val();
            location.href = '/?limit=' + limitNews;

            return false;
        });
    },
    getParamHref: function (name){
        var tmp = [];      // два вспомагательных
        var tmp2 = [];     // массива

        var get = location.search;  // строка GET запроса
        if(get != '')
        {
            tmp = (get.substr(1)).split('&');   // разделяем переменные
            for(var i=0; i < tmp.length; i++)
            {
                tmp2 = tmp[i].split('=');       // массив param будет содержать

                if (name == tmp2[0]) return tmp2[1];
            }
        }

        return null;
    }
};