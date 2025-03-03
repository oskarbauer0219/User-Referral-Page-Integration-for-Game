function copyToClipboard(text) { 
    if (navigator.clipboard) { 
        navigator.clipboard.writeText(text)
            .then(() => { 
                alert("Text copied successfully!"); 

            })
            .catch(err => { 
                console.error("Copy failed, error:", err); 
                fallbackCopyText(text); }); } 
    else { fallbackCopyText(text); } 
    } 
function fallbackCopyText(text) { 
    let textarea = document.createElement("textarea"); 
    textarea.value = text; document.body.appendChild(textarea); textarea.select(); 
    try { document.execCommand("copy"); alert("Text copied using fallback method!"); } 
    catch (err) { console.error("Copy failed:", err); } document.body.removeChild(textarea); 
} 