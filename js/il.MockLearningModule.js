/**
 * Created by Antonio on 27.04.2016.
 */
il.MockLearningModule = {

    rendered: false,
    base_url: "",
    $body:  $(document.body),
    loader_src: "",


    setBaseUrl: function(url) {
        var t = il.MockLearningModule;
        t.base_url = url;
    },

    getBaseUrl: function() {
        var t = il.MockLearningModule;
        return t.base_url;
    },

    setLoaderSrc: function(loader) {
        var t = il.MockLearningModule;
        t.loader_src = loader;
    },

    getLoaderSrc: function() {
        var t = il.MockLearningModule;
        return t.loader_src;
    },

    init: function () {
        var btn_group = document.getElementById('tttt').querySelectorAll(".btn-group");
        if (btn_group.length != null) {
            $('#switchMode').prependTo(btn_group[0]);
        } else {
            var div_tag = document.createElement('div');
            div_tag.className = 'ilHeadAction';
            div_tag.id = 'il_head_action';
            var inner_div = document.createElement('div');
            inner_div.id = 'tttt';
            inner_div.style = 'white-space: nowrap;';
            var btn_group_div = document.createElement('div');
            btn_group_div.className = 'btn-group';
            $('#switchMode').prependTo(btn_group_div);
            inner_div.appendChild(btn_group_div);
            div_tag.appendChild(inner_div);
            var header = document.getElementsByClassName('media il_HeaderInner');
            if (header.length != null) {
                header[0].appendChild(div_tag);
                $('#il_head_action').prependTo(header[0]);
            }
            ;
        }
        ;
    }
};