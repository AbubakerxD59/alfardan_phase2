/*Custom scroll for chat*/
$(".customscroll").mCustomScrollbar({
    autoHideScrollbar: true,
});
/*Custom scroll for chat*/

/*Multi Select Dropdown*/
$("#multiselect-drop").multiselect({
    columns: 1,
    placeholder: "Select Property",
    search: false,
    selectAll: true,
});
$("#multiselect-drop1").multiselect({
    columns: 1,
    placeholder: "Select Apartment",
    search: true,
    selectAll: true,
});
$("#multiselect-drop2").multiselect({
    columns: 1,
    placeholder: "Select Apartment",
    search: true,
    selectAll: true,
    onOptionClick: function (element, option) {
        console.log("element", $(element));
        console.log("option", $(option));
    },
});
$("#multiselect-drop3").multiselect({
    columns: 1,
    placeholder: "Select Property",
    search: false,
    selectAll: true,
});
$("#multiselect-drop4").multiselect({
    columns: 1,
    placeholder: "Select Tenant",
    search: false,
    selectAll: true,
});
$("#multiselect-drop5").multiselect({
    columns: 1,
    placeholder: "Select Tenant",
    search: false,
    selectAll: true,
});
$("#multiselect-drop6").multiselect({
    columns: 1,
    placeholder: "Select Property",
    search: false,
    selectAll: true,
});
$("#multiselect-drop7").multiselect({
    columns: 1,
    placeholder: "Select Tower",
    search: false,
    selectAll: true,
});
$("#multiselect-drop8").multiselect({
    columns: 1,
    placeholder: "Select Floor Number",
    search: false,
    selectAll: true,
});
$("#multiselect-drop9").multiselect({
    columns: 1,
    placeholder: "Select Tower",
    search: false,
    selectAll: true,
});
$("#multiselect-drop10").multiselect({
    columns: 1,
    placeholder: "Select Floor Number",
    search: false,
    selectAll: true,
});
$(".ms-selectall.global").click(function () {
    $(this).toggleClass("all");
});
/*Multi Select Dropdown End*/
jQuery(document).ready(function () {
    ImgUpload();
});

function ImgUpload() {
    var imgWrap = "";
    var imgArray = [];

    $(".upload__inputfile").each(function () {
        $(this).on("change", function (e) {
            imgWrap = $(this).closest(".upload__box").find(".upload__img-wrap");
            var maxLength = $(this).attr("data-max_length");

            var files = e.target.files;
            var filesArr = Array.prototype.slice.call(files);
            var iterator = 0;
            filesArr.forEach(function (f, index) {
                if (!f.type.match("image.*")) {
                    return;
                }

                if (imgArray.length > maxLength) {
                    return false;
                } else {
                    var len = 0;
                    for (var i = 0; i < imgArray.length; i++) {
                        if (imgArray[i] !== undefined) {
                            len++;
                        }
                    }
                    if (len > maxLength) {
                        return false;
                    } else {
                        imgArray.push(f);

                        var reader = new FileReader();
                        reader.onload = function (e) {
                            var html =
                                "<div class='upload__img-box'><div style='background-image: url(" +
                                e.target.result +
                                ")' data-number='" +
                                $(".upload__img-close").length +
                                "' data-file='" +
                                f.name +
                                "' class='img-bg'><div class='upload__img-close'></div></div></div>";
                            imgWrap.append(html);
                            iterator++;
                        };
                        reader.readAsDataURL(f);
                    }
                }
            });
        });
    });

    $("body").on("click", ".upload__img-close", function (e) {
        var file = $(this).parent().data("file");
        for (var i = 0; i < imgArray.length; i++) {
            if (imgArray[i].name === file) {
                imgArray.splice(i, 1);
                break;
            }
        }
        $(this).parent().parent().remove();
    });
}
const activePage = window.location.pathname;
const navLinks = document.querySelectorAll("nav a").forEach((link) => {
    if (link.href.includes(`${activePage}`)) {
        link.classList.add("active");
    } else {
        link.classList.remove("active");
    }
});
//dropdown code start

var x, i, j, l, ll, selElmnt, a, b, c;
/*look for any elements with the class "custom-select":*/
x = document.getElementsByClassName("custom-select2");
l = x.length;
for (i = 0; i < l; i++) {
    selElmnt = x[i].getElementsByTagName("select")[0];
    ll = selElmnt.length;
    /*for each element, create a new DIV that will act as the selected item:*/
    a = document.createElement("DIV");
    a.setAttribute("class", "select-selected");
    a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
    x[i].appendChild(a);
    /*for each element, create a new DIV that will contain the option list:*/
    b = document.createElement("DIV");
    b.setAttribute("class", "select-items select-hide");
    for (j = 1; j < ll; j++) {
        /*for each option in the original select element,
    create a new DIV that will act as an option item:*/
        c = document.createElement("DIV");
        c.innerHTML = selElmnt.options[j].innerHTML;
        c.addEventListener("click", function (e) {
            /*when an item is clicked, update the original select box,
        and the selected item:*/
            var y, i, k, s, h, sl, yl;
            s = this.parentNode.parentNode.getElementsByTagName("select")[0];
            sl = s.length;
            h = this.parentNode.previousSibling;
            for (i = 0; i < sl; i++) {
                if (s.options[i].innerHTML == this.innerHTML) {
                    s.selectedIndex = i;
                    h.innerHTML = this.innerHTML;
                    y =
                        this.parentNode.getElementsByClassName(
                            "same-as-selected"
                        );
                    yl = y.length;
                    for (k = 0; k < yl; k++) {
                        y[k].removeAttribute("class");
                    }
                    this.setAttribute("class", "same-as-selected");
                    break;
                }
            }
            h.click();
        });
        b.appendChild(c);
    }
    x[i].appendChild(b);
    a.addEventListener("click", function (e) {
        /*when the select box is clicked, close any other select boxes,
      and open/close the current select box:*/
        e.stopPropagation();
        closeAllSelect(this);
        this.nextSibling.classList.toggle("select-hide");
        this.classList.toggle("select-arrow-active");
    });
}
function closeAllSelect(elmnt) {
    /*a function that will close all select boxes in the document,
  except the current select box:*/
    var x,
        y,
        i,
        xl,
        yl,
        arrNo = [];
    x = document.getElementsByClassName("select-items");
    y = document.getElementsByClassName("select-selected");
    xl = x.length;
    yl = y.length;
    for (i = 0; i < yl; i++) {
        if (elmnt == y[i]) {
            arrNo.push(i);
        } else {
            y[i].classList.remove("select-arrow-active");
        }
    }
    for (i = 0; i < xl; i++) {
        if (arrNo.indexOf(i)) {
            x[i].classList.add("select-hide");
        }
    }
}
/*if the user clicks anywhere outside the select box,
then close all select boxes:*/
document.addEventListener("click", closeAllSelect);
