Validation.add('validate-for-discount', 'Please enter a correct data.', function(regSearch) {
    if (Validation.get('IsEmpty').test(regSearch)) {
        return true;
    }
    regSearch = (/^\S+(-?\d+%?)$/.test(regSearch));

    return regSearch;
});