; (function ($, window, undefined) {
    'use strict';

    $.fn.betterDropdown = function (options) {
        var settings = $.extend({}, $.fn.betterDropdown.defaults, options);
        if (settings.destroy) {
            destoryDropdown(this);
        } else {
            buildDropdown(this);
        }

        function buildDropdown(originalDropdown) {
            var itemName = settings.itemName;
            var id = originalDropdown[0].id;
            originalDropdown.hide();
            var parentContainer = originalDropdown.parent();
            //var className = itemName
            //    .toLowerCase()
            //    .replace(/\s/g, '-');

            // generate a random-ish identifier
            var className = Math.floor((Math.random() * 26) + Date.now());

            // if a better dropdown already exists for this item, remove it
            //$('.' + className + '-dropdown-box-wrapper').remove();
            //$('.' + className + '-filter-wrapper').remove();

            var $dropdownBox =
                $('<div class="' + className + '-dropdown-box-wrapper dropdown-box-wrapper ' + id + '">\
                        <span class="' + className + '-dropdown-box-text dropdown-box-text">'  + '</span>\
                    </div>');

            var $downArrow = $('<div class="down-arrow ' + className + '-dropdown-icon dropdown-icon"></div>');

            $downArrow.appendTo($dropdownBox);

            $dropdownBox
                .appendTo(parentContainer)
                .click(function () {
                    toggleDropdown();
                });

            var $filterWrapper = $('<div class="' + className + '-filter-wrapper filter-wrapper"></div>');

            var $filterBox = $('<input type="text" style="width:100%;color:#fff" placeholder="Search ' + itemName + 's..." class="' + className + '-filter-box filter-box"/>');
            $filterBox.appendTo($filterWrapper);

            var $filterResultsWrapper = $('<div class="' + className + '-filter-results-wrapper filter-results-wrapper"></div>');

            $.each($('#' + id).children(), function (i, option) {

                var $resultTextContainer = $('<span></span>');
                var $resultFirstText = $('<span>' + option.text + '</span>');
                //var $line = $('<hr style = \"margin: 0; height: 1.25px;\">');
                $resultFirstText.addClass('first-text');

                $resultTextContainer.append($resultFirstText);

                if (settings.displayTextBelow) {
                    var displayBelowText = $(option).data('display-below-text');
                    var $lineBreak = $('</br>');
                    var $resultLastText = $('<span style = \"color: lightgray\"> </span');

                    $resultLastText.text(displayBelowText);

                    $resultTextContainer
                        .append($lineBreak)
                        .append($resultLastText);
                }

                //$resultTextContainer.append($line);

                if (option.value !== '') {
                    var $filterResult = $('<div class="' + className + '-result result"></div>');
                    $filterResult
                        .data('value', option.value)
                        //.data('below-text', displayBelowText)
                        .data('filter-value', option.value.toUpperCase())
                        .data('filter-text', option.text.toUpperCase())
                        .appendTo($filterResultsWrapper)
                        .click(function () {
                            selectItem($filterResult);
                        })
                        .mouseover(function () {
                            hoverItem($filterResult);
                        })
                        .append($resultTextContainer);

                    if ($(option).data('displayBelowText')) {
                        $filterResult.data('filter-below-text', $(option).data('displayBelowText').toUpperCase());
                    }
                }
            });

            $filterResultsWrapper.appendTo($filterWrapper);
            $filterWrapper.appendTo(parentContainer);

            resizeDropdown();

            $('.' + className + '-filter-box').keyup(function (e) {

                // only filter the items if the key pressed isn't enter, up, down, left, or right arrow
                if (e.keyCode !== 13 &&
                    e.keyCode !== 37 &&
                    e.keyCode !== 38 &&
                    e.keyCode !== 39 &&
                    e.keyCode !== 40) {
                    filterItems($('.' + className + '-filter-box').val().toUpperCase());
                }
            });

            $('.' + className + '-filter-wrapper').keydown(function (e) {
                arrowKeyNavigate(e);
                $filterBox[0].selectionStart = $filterBox.val().length;
            });

            // if something was selected in the old dropdown, select it in the new one too
            if ($('#' + id).val() && $('#' + id).val() !== '') {
                selectItem($('.' + className + '-result').filter(function () {
                    return $(originalDropdown).data().value === $('#' + id).val();
                }));
            }

            $(window).resize(function () {
                resizeDropdown();
            });

            function selectItem($item) {
                $item.parent().children().removeClass('selected');
                $item.addClass('selected');
                hoverItem($item);

                $('.' + className + '-dropdown-box-text').text($item.children().first().children().first().text());

                // select the item in the original dropdown too
                $('#' + id + ' option[value="' + $item.data().value + '"]').prop("selected", true);
                $('#' + id).trigger("change");

                $('.' + className + '-filter-box').val('');
                $('.' + className + '-filter-box').keyup();

                closeDropdown();
            }

            function hoverItem($item) {
                $item.parent().children().removeClass('hovered');
                $item.addClass('hovered');
            }

            function filterItems(filterText) {
                // hide 'no items found' message
                $('.' + className + '-no-result-message').remove();

                var t0 = performance.now();

                // hide all items that don't contain filterText
                $.each($('.' + className + '-filter-results-wrapper').children(), function (i, option) {
                    var $option = $(option);

                    //don't change, css performs better than show/hide and addClass/removeClass
                    $option.css({ 'display': 'block' });

                    //https://www.learningjquery.com/2010/05/now-you-see-me-showhide-performance
                    var inDisplayName = $option.data('filter-text').indexOf(filterText) !== -1;
                    var inValue = $option.data('filter-value').indexOf(filterText) !== 1;

                    var inBelowText = false;

                    if ($(option).data('displayBelowText') &&
                        $(option).data('displayBelowText').indexOf(filterText !== -1)) {
                        inBelowText = true;
                    }

                    //if (!inDisplayName && !inValue) {
                    //    $option.hide();
                    //}

                    if (!inDisplayName && !inBelowText) {
                        $option.css({ 'display': 'none' });
                    }
                });

                var t1 = performance.now();
                console.log("first loop took " + (t1 - t0) + " milliseconds.");

                // if no items match the filter text, show message
                if ($('.' + className + '-filter-results-wrapper').children().filter(':visible').length === 0) {
                    var $itemNotFoundMessageContainer = $('<div class="' + className + '-no-result-message"></div>');

                    $('<i></i>')
                        .text('No ' + itemName.toLowerCase() + 's found.')
                        .appendTo($itemNotFoundMessageContainer.appendTo($filterResultsWrapper));
                }
            }

            function toggleDropdown() {
                var $filterWrapper = $('.' + className + '-filter-wrapper');
                var $filterBox = $('.' + className + '-filter-box');
                var $selectedItem = $('.' + className + '-result.selected');

                if ($filterWrapper.css('display') === 'none') {

                    // close all dropdowns before opening the current one
                    closeDropdowns();

                    $filterWrapper
                        .show()
                        .css('z-index', 11);

                    // if an item is selected, scroll the results wrapper to it
                    if ($selectedItem.length > 0) {
                        scrollFilterResultsWrapper($selectedItem);
                    }

                    $filterBox.focus();

                    // re-highlight the previously selected item
                    if ($selectedItem.length > 0) {
                        hoverItem($selectedItem);
                    }

                    flipDropdownArrow();
                }
                else {
                    closeDropdown();
                }
            }

            function closeDropdown() {
                $filterWrapper
                    .hide()
                    .css('z-index', 'auto');

                if ($('.' + className + '-dropdown-icon').hasClass('up-arrow')) {
                    flipDropdownArrow();
                }
            }

            function flipDropdownArrow() {
                var $dropdownIcon = $('.' + className + '-dropdown-icon');

                if ($dropdownIcon.hasClass('down-arrow')) {
                    $dropdownIcon
                        .addClass('up-arrow')
                        .removeClass('down-arrow');
                }
                else {
                    $dropdownIcon
                        .addClass('down-arrow')
                        .removeClass('up-arrow');
                }
            }

            function closeDropdowns() {
                $('.filter-wrapper').hide();
                $('.glyphicon-arrow-up')
                    .removeClass('up-arrow')
                    .addClass('down-arrow');
            }

            function arrowKeyNavigate(e) {
                var $hoveredItem = $('.' + className + '-result.hovered');
                var $nextItem = $hoveredItem.nextAll().filter(':visible').first(),
                    $prevItem = $hoveredItem.prevAll().filter(':visible').first(),
                    $firstItem = $filterResultsWrapper.children().filter(':visible').first(),
                    $lastItem = $filterResultsWrapper.children().filter(':visible').last();

                switch (e.which) {
                    case 40:
                        upOrDown($hoveredItem, $nextItem, $firstItem);
                        break;
                    case 38:
                        upOrDown($hoveredItem, $prevItem, $lastItem);
                        break;
                    case 13:
                        e.preventDefault();

                        if ($hoveredItem.length > 0) {
                            selectItem($hoveredItem);
                        }
                        break;
                }

                function upOrDown($item, $sibling, $wrapToItem) {
                    if ($item.length > 0) {
                        if ($sibling.length > 0) {
                            hoverItem($sibling);
                            scrollFilterResultsWrapper($sibling);
                        } else {
                            hoverItem($wrapToItem);
                            scrollFilterResultsWrapper($wrapToItem);
                        }
                    } else {
                        hoverItem($firstItem);
                        scrollFilterResultsWrapper($firstItem);
                    }
                }
            }

            function scrollFilterResultsWrapper($hoveredItem) {
                var hoverItemTop = $hoveredItem.offset().top;
                var hoverItemBottom = $hoveredItem.height() + hoverItemTop;
                var resultsWrapperTop = $('.' + className + '-filter-results-wrapper').offset().top;
                var resultsWrapperBottom = resultsWrapperTop + $('.' + className + '-filter-results-wrapper').height();
                var itemOffscreenBottomValue = hoverItemBottom - resultsWrapperBottom;
                var itemOffscreenTopValue = resultsWrapperTop - hoverItemTop;

                // if the hovered item is below the current scroll window
                if (itemOffscreenBottomValue > 0) {
                    $filterResultsWrapper.scrollTop($filterResultsWrapper.scrollTop() + itemOffscreenBottomValue);
                }

                // if the hovered item is above the current scroll window
                if (itemOffscreenTopValue > 0) {
                    $filterResultsWrapper.scrollTop($filterResultsWrapper.scrollTop() - itemOffscreenTopValue);
                }
            }

            function resizeDropdown() {
                var width = $('.dropdown-box-wrapper').width();

                $('.dropdown-box-text').width(width - 37);
                $('.filter-wrapper').width(width);
                $('.filter-box').width(width - 2);
                $('.dropdown-icon').css('padding-left', width - 28);
            }
        }

        function destoryDropdown(originalDropdown) {
            var id = originalDropdown[0].id;

            $('.' + id).remove();
        }
    }

    $.fn.betterDropdown.defaults = {
        itemName: 'Item',
        displayTextBelow: false,
        destroy: false
    };

})(jQuery, window);