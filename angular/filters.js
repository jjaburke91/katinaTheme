/**
 * Remember! Every filter using in a bind will be executed during each digest cycle.
 * Think about efficiency here, I bet a lot of this doesn't need to be dynamically generated.
 */

jmApp.filter('extractSurroundingTags', function() {
    /**
     * @deprecated ng-bind-html and $sce can sort this issue out.
     */
    return function(input, tag) {
        var result = "";
        if ( typeof input === 'string' ) {
            input = input || '';

            var leadingSearchString = "<" + tag + ">";
            var closingSearchString = "</" + tag + ">";

            result = input.replace(leadingSearchString, "");
            result = result.replace(closingSearchString, "");
        } else {
            console.error("extractSurroundingTags: input is not a string:");
            console.error(input);
        }

        return result;
    }
});

jmApp.filter('trustAsHtml', function($sce){
    return function(input){
        return $sce.trustAsHtml(input);
    }
});