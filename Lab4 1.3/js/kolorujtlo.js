var calc = false;
var dec = 0;

function convert (entryform, from, to)
{
    convertfrom = from.selectedIndex;
    convertto = to.selectedIndex;
    entryform.display.value = (entryform.input.value * from[convertfrom].value / to[convertto].value);
}

function addchar (input, character)
{
    if((character=='. ' && dec=="0") || character!='. ')
    {
        (input.value=='. ' || input.value == "0") ? input.value = character : input.value += character
        convert(input.form,input.form.measure1,input.form.measure2)
        calc = true;
        if (character=='. ')
        {
            dec = 1;
        }
    }
}

function openVothcom()
{
    window.open("","Display window","toolbar-no,directories-no,menubar-no");
}

function clear (form)
{
    form.input.value = 0;
    form.display.value = 0;
    dec=0;
}

function changeBackground(hexNumber)
{
	document.body.style.backgroundImage = 'none';
    document.body.style.backgroundColor = hexNumber;
}