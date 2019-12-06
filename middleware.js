//session  management middleware
module.exports =  async (request, response, next) => {
    //normalize the string as special characters in French are not displayed properly on USSD
    let normalize = true;
    let responseString = request.query.menuResponse;
    if (normalize) {
        let norm = require('normalize-strings');
        responseString = norm(responseString);
    }
    /**---------------------------------------
     *
     * MOST IMPORTANT VARIABLE ( ussd_env )
     *
     * ---------------------------------------
     */
    let ussd_env = request.query['ussd-response-format'] || 'safaricom';
    //form a proper response based on expected Mno variables
    let end_session = 'False';
    let responseObject = {};
    if (responseString.startsWith('END')) {
        end_session = 'True';
        responseString = responseString.replace(/END/g, '').trim();
    }
    switch (ussd_env) {
        case 'eclectics':
            responseObject = {
                'USSD_BODY': responseString,
                'END_OF_SESSION': end_session
            };
            break;
        case 'safaricom':
            let connectionString = end_session === 'True' ? 'END ' : 'CON ';
            responseObject = `${connectionString}${responseString}`;
            break;
    }
    response.send(responseObject);
}