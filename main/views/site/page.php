<!DOCTYPE html>
<html>

<head>
    <title>
        Pager
    </title>
    <script type="text/javascript">
        function togglediv(div) {
            if (div.style.display !== 'none') {
                div.style.display = 'none';
                console.log('hidden');
            } else {
                div.style.display = 'block';
                console.log('revealed');
            }
        }

        function removediv(div) {
            div.style.display = 'none';
        }

        // bottom is for the text editor
        var oDoc, sDefTxt;

        function initDoc() {
            oDoc = document.getElementById("textBox");
            sDefTxt = oDoc.innerHTML;
            if (document.compForm.switchMode.checked) {
                setDocMode(true);
            }
        }

        function formatDoc(sCmd, sValue) {
            if (validateMode()) {
                document.execCommand(sCmd, false, sValue);
                oDoc.focus();
            }
        }

        function validateMode() {
            if (!document.compForm.switchMode.checked) {
                return true;
            }
            alert("Uncheck \"Show HTML\".");
            oDoc.focus();
            return false;
        }

        function setDocMode(bToSource) {
            var oContent;
            if (bToSource) {
                oContent = document.createTextNode(oDoc.innerHTML);
                oDoc.innerHTML = "";
                var oPre = document.createElement("pre");
                oDoc.contentEditable = false;
                oPre.id = "sourceText";
                oPre.contentEditable = true;
                oPre.appendChild(oContent);
                oDoc.appendChild(oPre);
                document.execCommand("defaultParagraphSeparator", false, "div");
            } else {
                if (document.all) {
                    oDoc.innerHTML = oDoc.innerText;
                } else {
                    oContent = document.createRange();
                    oContent.selectNodeContents(oDoc.firstChild);
                    oDoc.innerHTML = oContent.toString();
                }
                oDoc.contentEditable = true;
            }
            oDoc.focus();
        }

        function printDoc() {
            if (!validateMode()) {
                return;
            }
            var oPrntWin = window.open("", "_blank", "width=450,height=470,left=400,top=100,menubar=yes,toolbar=no,location=no,scrollbars=yes");
            oPrntWin.document.open();
            oPrntWin.document.write("<!doctype html><html><head><title>Print<\/title><\/head><body onload=\"print();\">" + oDoc.innerHTML + "<\/body><\/html>");
            oPrntWin.document.close();
        }
    </script>
    <style type="text/css">
        body {
            background-color: #A8D0E6;
        }

        .divmain {
            color: rgb(114, 111, 111);
            margin: 5px 20px 5px 20px;
            border: 1px;
            border-radius: 15px;
        }

        #div0 {
            padding: 0px 30px 0px 30px;
            background-color: beige;
            display: flex;
            flex-flow: row;
            align-items: center;
        }

        #button0 {
            margin-left: auto;
            height: 45px;
            width: 120px;
            background-color: rgb(208, 228, 170);
            border: 1px;
            border-radius: 5px;
            border-color: beige;
            color: #555555;
        }

        #div1 {
            padding: 10px 60px 10px 60px;
            font-size: large;
            background-color: cornsilk;
        }

        #div2 {
            border: none;
            padding: 10px 30px 10px 30px;
            overflow: hidden;
            background-color: beige;
        }

        #button2 {
            float: right;
            height: 45px;
            width: 120px;
            background-color: rgb(208, 228, 170);
            border: 1px;
            border-radius: 5px;
            border-color: beige;
            color: #555555;
            margin: 0px 10px 0px 10px;
        }

        #div3 {
            border: solid;
            padding: 10px 60px 10px 60px;
            display: none;
        }

        .intLink {
            cursor: pointer;
        }

        img.intLink {
            border: 0;
        }

        #toolBar1 select {
            font-size: 10px;
        }

        #textBox {
            width: 540px;
            height: 200px;
            border: 1px #000000 solid;
            padding: 12px;
            overflow: scroll;
        }

        #textBox #sourceText {
            padding: 0;
            margin: 0;
            min-width: 498px;
            min-height: 200px;
        }

        #editMode label {
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div id="div0" class="divmain">
        <h1 id="h10" class="div0elements">Pager</h1>
        <button id="button0" class="div0elements">New note</button>
    </div>
    <div id="div1" class="divmain">
        <p>
            Gazi Husrev-beg, the second true founder of Sarajevo, is the greatest and most important legator in Bosnia and
            Herzegovina. Gazi Husrev-Bey's Library in Sarajevo was the first library, one of the oldest and most renowned legacies
            for which Gazi Husrev-Bey secured money and whose date of establishment is reliably recorded.

            Through the waqfnama about his madrasah, Gazi Husrev-Bey instructed: “Let the surplus left from the cost of constructing
            the madrasah be used for buying good books for use in the madrasah, to be used by readers and copied by those engaged in
            science.” Accordingly, we can ascertain that Gazi Husrev-Bey's Library is established simultaneously with madrasah in
            1537, noting its exact date of establishment, 26 Rajab 943 A.H., i.e. 8 January 1537.

            Until 1863, the Library was a part of the Kuršumlija Madrasah. That year, on the incentive of Topal Osman Pasha,
            Governor of Bosnia, the administration of Gazi Husrev-Bey's waqf built a larger room for the Library next to the Bey's
            Mosque, under the minaret. It remained there until 1935 when, due to the increase in the book collection, it was moved
            to the premises in front of the Careva Mosque, where it remained until the beginning of the aggression against Bosnia
            and Herzegovina in 1992. In April 1992, for security reasons, it was moved to several places in the city.

            During the four-year war, for the same reasons, the Library collection changed its location several times, and was thus
            completely preserved. After the aggression against BiH, the Library was located in the building next to the female
            section of the Gazi Husrev-Bey Madrasah at Drvenija at Hamdije Kreševljakovića Street 58, where it remained until 2013.

            Today, Gazi Husrev-Bey's library is located in the heart of the Old Town, in Gazi Husrev-begova St, 46, where a new,
            superb building was constructed specifically for this purpose. The new building was officially opened on 15 January
            2014; it was built and equipped with financial support of the State of Qatar. The building is located next to the
            western wall of the Kuršumlija Madrasah. In the end, the Library has returned to its original home, in the place of its
            founding and beginning, into the Gazi Husrev-Bey's waqf complex.

            The Gazi Husrev-Bey Library currently holds about one hundred thousand library units (manuscripts, printed books,
            journals and various documents) in Arabic, Turkish, Persian, Bosnian and several other European languages. Of these,
            more than 10,500 library units are manuscript codices with about 20,000 major and minor works from Islamic sciences,
            Oriental languages, fiction, philosophy, logic, history, medicine, veterinary science, mathematics, astronomy and other
            sciences.
        </p>
        <?php
        echo '<p>This is inserted using PHP.</p>';
        ?>
    </div>
    <div id="div2" class="divmain">
        <button id="button2" onclick="togglediv(document.getElementById('div3'))">Edit text</button>
        <button id="button2" onclick="removediv(document.getElementById('div3')); removediv(document.getElementById('div2'))">
            Remove edit feature
        </button>
    </div>
    <div id="div3" class="divmain">
        <form name="compForm" method="post" action="sample.php" onsubmit="if(validateMode()){this.myDoc.value=oDoc.innerHTML;return true;}return false;">
            <input type="hidden" name="myDoc">
            <div id="toolBar1">
                <select onchange="formatDoc('formatblock',this[this.selectedIndex].value);this.selectedIndex=0;">
                    <option selected>- formatting -</option>
                    <option value="h1">Title 1 &lt;h1&gt;</option>
                    <option value="h2">Title 2 &lt;h2&gt;</option>
                    <option value="h3">Title 3 &lt;h3&gt;</option>
                    <option value="h4">Title 4 &lt;h4&gt;</option>
                    <option value="h5">Title 5 &lt;h5&gt;</option>
                    <option value="h6">Subtitle &lt;h6&gt;</option>
                    <option value="p">Paragraph &lt;p&gt;</option>
                    <option value="pre">Preformatted &lt;pre&gt;</option>
                </select>
                <select onchange="formatDoc('fontname',this[this.selectedIndex].value);this.selectedIndex=0;">
                    <option class="heading" selected>- font -</option>
                    <option>Arial</option>
                    <option>Arial Black</option>
                    <option>Courier New</option>
                    <option>Times New Roman</option>
                </select>
                <select onchange="formatDoc('fontsize',this[this.selectedIndex].value);this.selectedIndex=0;">
                    <option class="heading" selected>- size -</option>
                    <option value="1">Very small</option>
                    <option value="2">A bit small</option>
                    <option value="3">Normal</option>
                    <option value="4">Medium-large</option>
                    <option value="5">Big</option>
                    <option value="6">Very big</option>
                    <option value="7">Maximum</option>
                </select>
                <select onchange="formatDoc('forecolor',this[this.selectedIndex].value);this.selectedIndex=0;">
                    <option class="heading" selected>- color -</option>
                    <option value="red">Red</option>
                    <option value="blue">Blue</option>
                    <option value="green">Green</option>
                    <option value="black">Black</option>
                </select>
                <select onchange="formatDoc('backcolor',this[this.selectedIndex].value);this.selectedIndex=0;">
                    <option class="heading" selected>- background -</option>
                    <option value="red">Red</option>
                    <option value="green">Green</option>
                    <option value="black">Black</option>
                </select>
            </div>
            <div id="toolBar2">
                <img class="intLink" title="Clean" onclick="if(validateMode()&&confirm('Are you sure?')){oDoc.innerHTML=sDefTxt};" src="data:image/gif;base64,R0lGODlhFgAWAIQbAD04KTRLYzFRjlldZl9vj1dusY14WYODhpWIbbSVFY6O7IOXw5qbms+wUbCztca0ccS4kdDQjdTLtMrL1O3YitHa7OPcsd/f4PfvrvDv8Pv5xv///////////////////yH5BAEKAB8ALAAAAAAWABYAAAV84CeOZGmeaKqubMteyzK547QoBcFWTm/jgsHq4rhMLoxFIehQQSAWR+Z4IAyaJ0kEgtFoLIzLwRE4oCQWrxoTOTAIhMCZ0tVgMBQKZHAYyFEWEV14eQ8IflhnEHmFDQkAiSkQCI2PDC4QBg+OAJc0ewadNCOgo6anqKkoIQA7" />
                <img class="intLink" title="Print" onclick="printDoc();" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABGdBTUEAALGPC/xhBQAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9oEBxcZFmGboiwAAAAIdEVYdENvbW1lbnQA9syWvwAAAuFJREFUOMvtlUtsjFEUx//n3nn0YdpBh1abRpt4LFqtqkc3jRKkNEIsiIRIBBEhJJpKlIVo4m1RRMKKjQiRMJRUqUdKPT71qpIpiRKPaqdF55tv5vvusZjQTjOlseUkd3Xu/3dPzusC/22wtu2wRn+jG5So/OCDh8ycMJDflehMlkJkVK7KUYN+ufzA/RttH76zaVocDptRxzQtNi3mRWuPc+6cKtlXZ/sddP2uu9uXlmYXZ6Qm8v4Tz8lhF1H+zDQXt7S8oLMXtbF4e8QaFHjj3kbP2MzkktHpiTjp9VH6iHiA+whtAsX5brpwueMGdONdf/2A4M7ukDs1JW662+XkqTkeUoqjKtOjm2h53YFL15pSJ04Zc94wdtibr26fXlC2mzRvBccEbz2kiRFD414tKMlEZbVGT33+qCoHgha81SWYsew0r1uzfNylmtpx80pngQQ91LwVk2JGvGnfvZG6YcYRAT16GFtW5kKKfo1EQLtfh5Q2etT0BIWF+aitq4fDbk+ImYo1OxvGF03waFJQvBCkvDffRyEtxQiFFYgAZTHS0zwAGD7fG5TNnYNTp8/FzvGwJOfmgG7GOx0SAKKgQgDMgKBI0NJGMEImpGDk5+WACEwEd0ywblhGUZ4Hw5OdUekRBLT7DTgdEgxACsIznx8zpmWh7k4rkpJcuHDxCul6MDsmmBXDlWCH2+XozSgBnzsNCEE4euYV4pwCpsWYPW0UHDYBKSWu1NYjENDReqtKjwn2+zvtTc1vMSTB/mvev/WEYSlASsLimcOhOBJxw+N3aP/SjefNL5GePZmpu4kG7OPr1+tOfPyUu3BecWYKcwQcDFmwFKAUo90fhKDInBCAmvqnyMgqUEagQwCoHBDc1rjv9pIlD8IbVkz6qYViIBQGTJPx4k0XpIgEZoRN1Da0cij4VfR0ta3WvBXH/rjdCufv6R2zPgPH/e4pxSBCpeatqPrjNiso203/5s/zA171Mv8+w1LOAAAAAElFTkSuQmCC">
                <img class="intLink" title="Undo" onclick="formatDoc('undo');" src="data:image/gif;base64,R0lGODlhFgAWAOMKADljwliE33mOrpGjuYKl8aezxqPD+7/I19DV3NHa7P///////////////////////yH5BAEKAA8ALAAAAAAWABYAAARR8MlJq7046807TkaYeJJBnES4EeUJvIGapWYAC0CsocQ7SDlWJkAkCA6ToMYWIARGQF3mRQVIEjkkSVLIbSfEwhdRIH4fh/DZMICe3/C4nBQBADs=" />
                <img class="intLink" title="Redo" onclick="formatDoc('redo');" src="data:image/gif;base64,R0lGODlhFgAWAMIHAB1ChDljwl9vj1iE34Kl8aPD+7/I1////yH5BAEKAAcALAAAAAAWABYAAANKeLrc/jDKSesyphi7SiEgsVXZEATDICqBVJjpqWZt9NaEDNbQK1wCQsxlYnxMAImhyDoFAElJasRRvAZVRqqQXUy7Cgx4TC6bswkAOw==" />
                <img class="intLink" title="Remove formatting" onclick="formatDoc('removeFormat')" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABYAAAAWCAYAAADEtGw7AAAABGdBTUEAALGPC/xhBQAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlzAAAOxAAADsQBlSsOGwAAAAd0SU1FB9oECQMCKPI8CIIAAAAIdEVYdENvbW1lbnQA9syWvwAAAuhJREFUOMtjYBgFxAB501ZWBvVaL2nHnlmk6mXCJbF69zU+Hz/9fB5O1lx+bg45qhl8/fYr5it3XrP/YWTUvvvk3VeqGXz70TvbJy8+Wv39+2/Hz19/mGwjZzuTYjALuoBv9jImaXHeyD3H7kU8fPj2ICML8z92dlbtMzdeiG3fco7J08foH1kurkm3E9iw54YvKwuTuom+LPt/BgbWf3//sf37/1/c02cCG1lB8f//f95DZx74MTMzshhoSm6szrQ/a6Ir/Z2RkfEjBxuLYFpDiDi6Af///2ckaHBp7+7wmavP5n76+P2ClrLIYl8H9W36auJCbCxM4szMTJac7Kza////R3H1w2cfWAgafPbqs5g7D95++/P1B4+ECK8tAwMDw/1H7159+/7r7ZcvPz4fOHbzEwMDwx8GBgaGnNatfHZx8zqrJ+4VJBh5CQEGOySEua/v3n7hXmqI8WUGBgYGL3vVG7fuPK3i5GD9/fja7ZsMDAzMG/Ze52mZeSj4yu1XEq/ff7W5dvfVAS1lsXc4Db7z8C3r8p7Qjf///2dnZGxlqJuyr3rPqQd/Hhyu7oSpYWScylDQsd3kzvnH738wMDzj5GBN1VIWW4c3KDon7VOvm7S3paB9u5qsU5/x5KUnlY+eexQbkLNsErK61+++VnAJcfkyMTIwffj0QwZbJDKjcETs1Y8evyd48toz8y/ffzv//vPP4veffxpX77z6l5JewHPu8MqTDAwMDLzyrjb/mZm0JcT5Lj+89+Ybm6zz95oMh7s4XbygN3Sluq4Mj5K8iKMgP4f0////fv77//8nLy+7MCcXmyYDAwODS9jM9tcvPypd35pne3ljdjvj26+H2dhYpuENikgfvQeXNmSl3tqepxXsqhXPyc666s+fv1fMdKR3TK72zpix8nTc7bdfhfkEeVbC9KhbK/9iYWHiErbu6MWbY/7//8/4//9/pgOnH6jGVazvFDRtq2VgiBIZrUTIBgCk+ivHvuEKwAAAAABJRU5ErkJggg==">
                <img class="intLink" title="Bold" onclick="formatDoc('bold');" src="data:image/gif;base64,R0lGODlhFgAWAID/AMDAwAAAACH5BAEAAAAALAAAAAAWABYAQAInhI+pa+H9mJy0LhdgtrxzDG5WGFVk6aXqyk6Y9kXvKKNuLbb6zgMFADs=" />
                <img class="intLink" title="Italic" onclick="formatDoc('italic');" src="data:image/gif;base64,R0lGODlhFgAWAKEDAAAAAF9vj5WIbf///yH5BAEAAAMALAAAAAAWABYAAAIjnI+py+0Po5x0gXvruEKHrF2BB1YiCWgbMFIYpsbyTNd2UwAAOw==" />
                <img class="intLink" title="Underline" onclick="formatDoc('underline');" src="data:image/gif;base64,R0lGODlhFgAWAKECAAAAAF9vj////////yH5BAEAAAIALAAAAAAWABYAAAIrlI+py+0Po5zUgAsEzvEeL4Ea15EiJJ5PSqJmuwKBEKgxVuXWtun+DwxCCgA7" />
                <img class="intLink" title="Left align" onclick="formatDoc('justifyleft');" src="data:image/gif;base64,R0lGODlhFgAWAID/AMDAwAAAACH5BAEAAAAALAAAAAAWABYAQAIghI+py+0Po5y02ouz3jL4D4JMGELkGYxo+qzl4nKyXAAAOw==" />
                <img class="intLink" title="Center align" onclick="formatDoc('justifycenter');" src="data:image/gif;base64,R0lGODlhFgAWAID/AMDAwAAAACH5BAEAAAAALAAAAAAWABYAQAIfhI+py+0Po5y02ouz3jL4D4JOGI7kaZ5Bqn4sycVbAQA7" />
                <img class="intLink" title="Right align" onclick="formatDoc('justifyright');" src="data:image/gif;base64,R0lGODlhFgAWAID/AMDAwAAAACH5BAEAAAAALAAAAAAWABYAQAIghI+py+0Po5y02ouz3jL4D4JQGDLkGYxouqzl43JyVgAAOw==" />
                <img class="intLink" title="Numbered list" onclick="formatDoc('insertorderedlist');" src="data:image/gif;base64,R0lGODlhFgAWAMIGAAAAADljwliE35GjuaezxtHa7P///////yH5BAEAAAcALAAAAAAWABYAAAM2eLrc/jDKSespwjoRFvggCBUBoTFBeq6QIAysQnRHaEOzyaZ07Lu9lUBnC0UGQU1K52s6n5oEADs=" />
                <img class="intLink" title="Dotted list" onclick="formatDoc('insertunorderedlist');" src="data:image/gif;base64,R0lGODlhFgAWAMIGAAAAAB1ChF9vj1iE33mOrqezxv///////yH5BAEAAAcALAAAAAAWABYAAAMyeLrc/jDKSesppNhGRlBAKIZRERBbqm6YtnbfMY7lud64UwiuKnigGQliQuWOyKQykgAAOw==" />
                <img class="intLink" title="Quote" onclick="formatDoc('formatblock','blockquote');" src="data:image/gif;base64,R0lGODlhFgAWAIQXAC1NqjFRjkBgmT9nqUJnsk9xrFJ7u2R9qmKBt1iGzHmOrm6Sz4OXw3Odz4Cl2ZSnw6KxyqO306K63bG70bTB0rDI3bvI4P///////////////////////////////////yH5BAEKAB8ALAAAAAAWABYAAAVP4CeOZGmeaKqubEs2CekkErvEI1zZuOgYFlakECEZFi0GgTGKEBATFmJAVXweVOoKEQgABB9IQDCmrLpjETrQQlhHjINrTq/b7/i8fp8PAQA7" />
                <img class="intLink" title="Delete indentation" onclick="formatDoc('outdent');" src="data:image/gif;base64,R0lGODlhFgAWAMIHAAAAADljwliE35GjuaezxtDV3NHa7P///yH5BAEAAAcALAAAAAAWABYAAAM2eLrc/jDKCQG9F2i7u8agQgyK1z2EIBil+TWqEMxhMczsYVJ3e4ahk+sFnAgtxSQDqWw6n5cEADs=" />
                <img class="intLink" title="Add indentation" onclick="formatDoc('indent');" src="data:image/gif;base64,R0lGODlhFgAWAOMIAAAAADljwl9vj1iE35GjuaezxtDV3NHa7P///////////////////////////////yH5BAEAAAgALAAAAAAWABYAAAQ7EMlJq704650B/x8gemMpgugwHJNZXodKsO5oqUOgo5KhBwWESyMQsCRDHu9VOyk5TM9zSpFSr9gsJwIAOw==" />
                <img class="intLink" title="Hyperlink" onclick="var sLnk=prompt('Write the URL here','http:\/\/');if(sLnk&&sLnk!=''&&sLnk!='http://'){formatDoc('createlink',sLnk)}" src="data:image/gif;base64,R0lGODlhFgAWAOMKAB1ChDRLY19vj3mOrpGjuaezxrCztb/I19Ha7Pv8/f///////////////////////yH5BAEKAA8ALAAAAAAWABYAAARY8MlJq7046827/2BYIQVhHg9pEgVGIklyDEUBy/RlE4FQF4dCj2AQXAiJQDCWQCAEBwIioEMQBgSAFhDAGghGi9XgHAhMNoSZgJkJei33UESv2+/4vD4TAQA7" />
                <img class="intLink" title="Cut" onclick="formatDoc('cut');" src="data:image/gif;base64,R0lGODlhFgAWAIQSAB1ChBFNsRJTySJYwjljwkxwl19vj1dusYODhl6MnHmOrpqbmpGjuaezxrCztcDCxL/I18rL1P///////////////////////////////////////////////////////yH5BAEAAB8ALAAAAAAWABYAAAVu4CeOZGmeaKqubDs6TNnEbGNApNG0kbGMi5trwcA9GArXh+FAfBAw5UexUDAQESkRsfhJPwaH4YsEGAAJGisRGAQY7UCC9ZAXBB+74LGCRxIEHwAHdWooDgGJcwpxDisQBQRjIgkDCVlfmZqbmiEAOw==" />
                <img class="intLink" title="Copy" onclick="formatDoc('copy');" src="data:image/gif;base64,R0lGODlhFgAWAIQcAB1ChBFNsTRLYyJYwjljwl9vj1iE31iGzF6MnHWX9HOdz5GjuYCl2YKl8ZOt4qezxqK63aK/9KPD+7DI3b/I17LM/MrL1MLY9NHa7OPs++bx/Pv8/f///////////////yH5BAEAAB8ALAAAAAAWABYAAAWG4CeOZGmeaKqubOum1SQ/kPVOW749BeVSus2CgrCxHptLBbOQxCSNCCaF1GUqwQbBd0JGJAyGJJiobE+LnCaDcXAaEoxhQACgNw0FQx9kP+wmaRgYFBQNeAoGihCAJQsCkJAKOhgXEw8BLQYciooHf5o7EA+kC40qBKkAAAGrpy+wsbKzIiEAOw==" />
                <img class="intLink" title="Paste" onclick="formatDoc('paste');" src="data:image/gif;base64,R0lGODlhFgAWAIQUAD04KTRLY2tXQF9vj414WZWIbXmOrpqbmpGjudClFaezxsa0cb/I1+3YitHa7PrkIPHvbuPs+/fvrvv8/f///////////////////////////////////////////////yH5BAEAAB8ALAAAAAAWABYAAAWN4CeOZGmeaKqubGsusPvBSyFJjVDs6nJLB0khR4AkBCmfsCGBQAoCwjF5gwquVykSFbwZE+AwIBV0GhFog2EwIDchjwRiQo9E2Fx4XD5R+B0DDAEnBXBhBhN2DgwDAQFjJYVhCQYRfgoIDGiQJAWTCQMRiwwMfgicnVcAAAMOaK+bLAOrtLUyt7i5uiUhADs=" />
            </div>
            <div id="textBox" contenteditable="true">
                <p>Lorem ipsum</p>
            </div>
            <p id="editMode"><input type="checkbox" name="switchMode" id="switchBox" onchange="setDocMode(this.checked);" />
                <label for="switchBox">Show HTML</label></p>
            <p>
                <input type="submit" value="Save" />
            </p>
        </form>
    </div>
</body>

</html>