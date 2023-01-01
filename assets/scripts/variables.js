/**
 * Keys to identify in the performance records when searching
 */
const performanceKeys = {
    id:"data-id", breed:"data-breed", 
    birth:"data-birth-type", sex:"data-sex", 
    weight:"data-bl-weight", sire:"data-sire-id",
    suck:"data-suck-date", litter:"data-litter-size"
}

/**
 * Keys to identify in the animal records when searching
 */
const recordsKeys = {
    id:"data-id", breed:"data-breed", sex:"data-sex", 
    weight:"data-b-weight", sire:"data-sire-id",
    dam: "data-dam-id", dob: "data-dob",
    wean: "data-w-weight"
}

/**
 * Keys to identify in the weighing records when searching
 */
const weighKeys = {
    id:"data-id", breed:"data-breed", sex:"data-sex", 
    weight:"data-weight", date:"data-date",
}

/**
 * Function to provide the key to use
 * @return {array} returns the required keys
 */
function getKeys(){
    url = $(location).attr("href");

    if(url.includes("performance")){
        return performanceKeys;
    }else if(url.includes("records")){
        return recordsKeys;
    }else if(url.includes("weight")){
        return weighKeys;
    }
}