let nameSymbols = [];
nameSymbols[1072] = 'a';
nameSymbols.push('b', 'v', 'g', 'd', 'e', 'zh', 'z', 'i', 'y', 'k', 'l', 'm', 'n', 'o',
    'p', 'r', 's', 't', 'u', 'f', 'h', 'c', 'ch', 'sh', 'shch', '', 'y', '', 'e',
    'yu', 'ya', '', 'yo'
);

function NameTranslit(name)
{
    name = name.toLowerCase();
    name = name.replace(/ /g, '-');
    name = name.replace(/[.,:;]/g, '');
    
    let alias = '';
    for (let symbol of name) {
        let symbolCode = symbol.charCodeAt(0);
        if (symbolCode > 1071 && symbolCode < 1106) {
            alias += nameSymbols[symbolCode];
        } else {
            alias += symbol;
        }
    }
    return alias;
}