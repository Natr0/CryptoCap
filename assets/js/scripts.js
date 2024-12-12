$(document).ready(function() {
    const apiUrl = "https://api.coincap.io/v2/assets";
    const euroRateUrl = "https://api.coincap.io/v2/rates/euro";
    let euroRate;

    // Euro wisselkoers
    $.getJSON(euroRateUrl, function(data) {
        euroRate = 1 / data.data.rateUsd;
    });

    // cryptocurrency gegevens 
    $.getJSON(apiUrl, function(data) {
        const cryptoList = data.data;
        let content = '';

        cryptoList.forEach(crypto => {
            const priceUsd = parseFloat(crypto.priceUsd);
            const priceEur = (priceUsd * euroRate).toFixed(2);

            content += `
                <div class="col-md-4">
                    <div class="crypto-card">
                        <h5>${crypto.name} (${crypto.symbol})</h5>
                        <p>Rank: ${crypto.rank}</p>
                        <p>Prijs: $${priceUsd.toFixed(2)} | €${priceEur}</p>
                        <p>Volume: $${parseFloat(crypto.volumeUsd24Hr).toFixed(2)}</p>
                        <a href="${crypto.explorer}" target="_blank" class="btn btn-primary">Meer Info</a>
                    </div>
                </div>
            `;
        });

        $('#crypto-list').html(content);
    });
});
