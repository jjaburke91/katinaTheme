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


jmApp.filter('trustAsHtmlFilter', function($sce) {
    console.log("trust hit");
    console.log( $sce.trustAsHtml());
    return $sce.trustAsHtml;
});