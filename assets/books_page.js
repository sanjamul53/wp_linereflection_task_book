
const cat_click_handler  = (e, isClear=false) => {

    const filterKey = 'book_category';

    const searchParams = new URLSearchParams(window.location.search);


    if(e && !isClear) {

        const termId = e.getAttribute('termid');

        searchParams.set(filterKey, termId);
    
        if (termId) {
          searchParams.set(filterKey, termId);
        } 
        else {
          searchParams.delete(filterKey);
        }

    }
    else {
        searchParams.delete(filterKey);
    }

    
    window.location.search = searchParams.toString();

}


const cat_click_all_handler = () => { 
    cat_click_handler(null, true);

}
