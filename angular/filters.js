jmApp.filter('extractSurroundingTags', function() {
    return function(input, tag) {
        input = input || '';

        var leadingSearchString = "<" + tag + ">";
        var closingSearchString = "</" + tag + ">";

        var result = input.replace(leadingSearchString, "");
        result = result.replace(closingSearchString, "");

        return result;
    }
});

jmApp.filter('trustAsHtml', function($sce){
    return function(input){
        return $sce.trustAsHtml(input);
    }
})