$(function () {
    var descriptionEn = $('#description-en').val(),
        editorDescriptionEn = $('#edit-desription-en');
    if (!descriptionEn) {
        descriptionEn = "";
    }
    var descriptionJa = $('#description-ja').val(),
        editorDescriptionJa = $('#edit-desription-ja');
    if (!descriptionJa) {
        descriptionJa = "";
    }

    // Content Editor
    editorDescriptionEn.froalaEditor({
        toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript',
            'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|',
            'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', '-',
            'insertLink', 'insertTable', 'undo', 'redo', 'clearFormatting',
            'selectAll', 'html'],
        height: 500,
        heightMin: 500,
        heightMax: 500,

    });
    editorDescriptionEn.froalaEditor('html.set', descriptionEn, true);

    editorDescriptionJa.froalaEditor({
        toolbarButtons: ['fullscreen', 'bold', 'italic', 'underline', 'strikeThrough', 'subscript', 'superscript',
            'fontFamily', 'fontSize', '|', 'color', 'emoticons', 'inlineStyle', 'paragraphStyle', '|',
            'paragraphFormat', 'align', 'formatOL', 'formatUL', 'outdent', 'indent', 'quote', 'insertHR', '-',
            'insertLink', 'insertTable', 'undo', 'redo', 'clearFormatting',
            'selectAll', 'html'],
        height: 500,
        heightMin: 500,
        heightMax: 500,

    });
    editorDescriptionJa.froalaEditor('html.set', descriptionJa, true);

    var saveButton = $("#button-save");
    saveButton.click(function () {
        var editorDescriptionEn = $('#edit-desription-en'),
            htmlEn = editorDescriptionEn.froalaEditor('html.get', false, false);
        $('#description-en').val(htmlEn);
        var editorDescriptionJa = $('#edit-desription-ja'),
            htmlJa = editorDescriptionJa.froalaEditor('html.get', false, false);
        $('#description-ja').val(htmlJa);
        $('#form-category').submit();
        return false;
    });


});
