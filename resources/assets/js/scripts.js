/**
 * Created by angga on 22/02/17.
 */
$(document).ready(function () {
    if ($('.content-wrapper').outerHeight() < $(window).height() - 130) {
        $('footer').addClass('navbar-fixed-bottom');
    }

    if ($('#page-content-wrapper').outerHeight() < $(window).height()) {
        $('footer').addClass('fixed');
    }

    $('.btn-icon-search').on('click', function (e) {
        e.preventDefault();
        $(this).fadeOut(100, function(){
            $('.form-search-wrapper').show(100)
                .find("input[type=search]").focus();
        });
    });

    $('.form-search-wrapper input[type=search]').on('focusout', function () {
        $('.form-search-wrapper').hide(100, function () {
            $('.btn-icon-search').fadeIn(100);
        });
    });

    var tagsData = new Bloodhound({
        datumTokenizer: Bloodhound.tokenizers.obj.whitespace('tag'),
        queryTokenizer: Bloodhound.tokenizers.whitespace,
        local: [{tag: 'design'}, {tag: 'art'}, {tag: 'ui'}, {tag: 'ux'}, {tag: 'visual'}, {tag: 'graphic'}, {tag: 'technology'}, {tag: 'medical'}, {tag: 'architecture'}],
        remote: {
            url: window.Showcase.rootUrl + '/tag/search/%QUERY',
            wildcard: '%QUERY'
        }
    });
    tagsData.initialize();

    $('input[name=tags]').tagsinput({
        typeaheadjs: [{
            minLength: 1,
            highlight: true,
        }, {
            minlength: 1,
            name: 'tags',
            displayKey: 'tag',
            valueKey: 'tag',
            source: tagsData.ttAdapter()
        }],
        freeInput: true
    });
    /*
     $('input[name=tags]').typeahead({
     hint: true,
     highlight: true,
     minLength: 1
     },
     {
     name: 'states',
     source: states
     });
     */
    if ($('.screenshot-wrapper').length) {
        var totalScreenshots = $('.screenshot-wrapper').children().length - 1;
        var limitImage = 8;

        $(document).on('change', '.screenshot-file', function () {
            var input = $(this);
            var isFilenameExist = input.parent().find('.screenshot-filename').length;
            var isPreviewExist = input.parent().find('.screenshot-preview').length;

            if (isFilenameExist) {
                //input.parent().find('.screenshot-filename').html(input.val());
            }
            else {
                //$('<p/>').html(input.val()).addClass('screenshot-filename').insertBefore(input);
            }

            input.parent().find('.screenshot-preview').css('background-image', 'none')
                .text('LOAD IMAGES');

            var file = input[0].files[0];
            var reader = new FileReader();
            reader.onload = function (e) {
                if (isPreviewExist) {
                    input.parent().find('.screenshot-preview')
                        .css('background-image', 'url(' + e.target.result.toString() + ')');
                }
                else {
                    $("<div/>").addClass('screenshot-preview')
                        .css('background-image', 'url(' + e.target.result.toString() + ')')
                        .prependTo(input.parent());
                }

                input.parent().find('.screenshot-preview').text('');

                // check if it's not update photo
                if (input.attr('id') == 'add-screenshot') {
                    totalScreenshots++;
                    if (totalScreenshots < limitImage) {
                        addMorePhoto();
                    }
                    screenshotOrder();
                }
            }
            reader.readAsDataURL(file);
        });

        $(document).on('click', '.remove-screenshot', function (e) {
            e.preventDefault();
            $(this).closest('.screenshot-item').remove();
            totalScreenshots--;
            if (totalScreenshots == limitImage - 1) {
                addMorePhoto(totalScreenshots);
            }
            screenshotOrder();
        });

        function addMorePhoto() {
            var addScreenshotTag =
                '<div class="col-md-3 screenshot-item">' +
                '<div class="form-group">' +
                '<label for="add-screenshot" class="control-label">Add Screenshot</label>' +
                '<div class="file">' +
                '<label for="add-screenshot" class="screenshot-preview">ADD IMAGE</label>' +
                '<input type="file" name="screenshots[]" id="add-screenshot" class="inputfile screenshot-file" accept="image/png,image/gif,image/jpeg">' +
                '<label for="add-screenshot" class="btn btn-default">Choose a file</label>' +
                '</div>' +
                '</div>' +
                '</div>';
            $('.screenshot-wrapper').append(addScreenshotTag);
        }

        function screenshotOrder() {
            var count = 0;
            var totalPreview = $('.screenshot-wrapper').children().length;
            $('.screenshot-wrapper').children().each(function () {
                count++;
                // sort all uploaded file - 1 (add new) or sort all if reach the limit
                // if($(this).attr('id') == 'add-screenshot')
                if (count < totalPreview || totalScreenshots == limitImage) {
                    $(this).find('.control-label')
                        .attr('for', 'add-screenshot' + count)
                        .text('Screenshot ' + count)
                        .append('<a href="#screenshot' + count + '" class="remove-screenshot text-danger pull-right">Remove</a>');
                    $(this).find('.screenshot-file')
                        .attr('id', 'add-screenshot' + count);
                    $(this).find('.btn')
                        .attr('for', 'add-screenshot' + count)
                        .text('Change Image');
                    $(this).find('.screenshot-preview')
                        .attr('for', 'add-screenshot' + count)
                        .css('border', 'none');
                }
            });
        }
    }
});