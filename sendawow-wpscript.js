jQuery(document).ready(function() {
    jQuery('.wp-saw-button').sendawow({
        //Your Coin Address
        address      : sawdata.address,
        //Default Amount
        amount       : sawdata.amount,
        //Coin Symbol
        coinsign     : sawdata.coinsign,
        //Network
        network      : sawdata.network,
        //Text for Button
        button_text  : sawdata.button_text,
        //Site Name
        blogname     : sawdata.blogname,
        //Info Text
        info         : sawdata.info,
        //Read More Text
        readmore     : sawdata.readmore,
        //Read More Url
        readmoreurl  : sawdata.readmoreurl,
        //Label for Address
        addresslabel : sawdata.addresslabel,
        //Label for Amount
        amountlabel  : sawdata.amountlabel,
        //Donation to Developers (in %)
        devdonation  : sawdata.devdonation
    });
});