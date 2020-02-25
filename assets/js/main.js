$(document).ready(function(){
    const baseUrl = "http://localhost/Investus/";

    //send email
    $('#forgotForm').submit((e)=>{
        $('#forgotModal').modal("show");
    });

    //function to buy stock
    $('#buyStock').click(()=>{
        let quantity = $('#stockQuantity').val();
        const symbol = (window.location.pathname).split("/")[4];
        let sendData = {
            amount: quantity,
            symbol: symbol,
            buyStock: ""
        };
        //  xhr request
        $.ajax({
            type: "POST",
            url: baseUrl + "ajax/buyStock",
            dataType: "json",
            data: sendData,
            success: function(response){ 
                if(response.success){
                    const total = (response.total*response.currency_value).toFixed(2);
                    $('#modalTitle').text('Purchase completed!');
                    $("#modalMsg").text(`
                     You bought ${response.amount} action(s) from ${response.symbol}, total ${total} ${response.user_currency}.   
                    `);
                } else {
                    $('#modalMsg').text(response.reason);
                };
            },
            error: function(err){
                console.log(err);
            }
        })
    });
    const sellDefaultTitle = $('#sellModalTitle').html();
    const sellDefaultMsg = $('#modalSellMsg').html();
    const buyDefaultTitle = $('#modalTitle').html();
    const buyDefaultMsg = $('#modalMsg').html();
    $('.close').click(()=>{
        $('#sellModalTitle').html(sellDefaultTitle);
        $('#modalSellMsg').html(sellDefaultMsg);
        $('#modalTitle').html(buyDefaultTitle);
        $('#modalMsg').html(buyDefaultMsg);
    })
    //function to sell stock
    $('#sellStock').click(()=>{
        let quantity = $('#sellStockQuantity').val();
        const symbol = (window.location.pathname).split("/")[4];
        let sendData = {
            amount: quantity,
            symbol: symbol,
            sellStock: ""
        };
        //  xhr request
        $.ajax({
            type: "POST",
            url: baseUrl + "ajax/sellStock",
            dataType: "json",
            data: sendData,
            success: function(response){
                if(response.success){
                    const total = response.convertedValue.toFixed(2); 
                    $('#sellModalTitle').text("Actions sold!");
                    $('#modalSellMsg').text(`
                     You sold ${response.amount} action(s) from ${response.symbol}, total ${total} ${response.currencyUsed}.
                    `);
                } else if(response.status == 400){
                    $('#modalSellMsg').text(response.reason);
                } 
                else {
                    $('#sellModalTitle').text(response.reason);
                    $('#modalSellMsg').text(`
                     We are so sorry, but you don't have enough actions to sell.
                    `);
                }
            },
            error: function(error){
                console.log(error);
            }
        })
    });
    $("#withdrawBtn").click(()=>{
        let quantity = Number($("#withdrawAmount").val());
        if(quantity >= 0) return false;
        let request = {
            amount: quantity,
            withdraw: ""
        }
        $.ajax({
            type: "POST",
            url: baseUrl + "ajax/withdraw",
            dataType: "json",
            data: request,
            success: function(response){
                if(!response.success){
                    if(response.reason == 400) {
                        $('#modalMoneyFail').modal("show");
                        $('#modalMoneyFailMsg').html(`
                            <p>
                                Insufficient funds, please verify your withdraw value request.
                            </p>
                        `);
                    } else if(response.reason == 403) {
                        $('#modalIbanFail').modal("show");
                        $('#modalIbanFailMsg').html(`
                            <p>
                                Iban must be inserted in order to withdraw money.
                            </p>`);
                    }
                }
                if(response.success){
                    $('#modalWithdraw').modal("show")
                    $("#withdrawMsg").html(`
                        <p>
                            You withdrew ${response.convertedValue} ${response.currencyUsed} by bank transfer.
                            IBAN: ${response.iban}.
                        </p>
                    `)
                }
            },
            error: function(err){
                console.log(err);
            }
        })
    })
    //fetch currency rates
    async function fetchCurrency(){
        $.ajax({
            type: "GET",
            url: "https://api.exchangeratesapi.io/latest",
            dataType: "json",
            success: function(response){
                return response;
            },
            error: function(err){
                alert(err);
            }
        })
    }

    window.addEventListener("scroll", ()=>{
        if(window.pageYOffset != 0 && $('#menu')){
            $('#menu').addClass('backgroundWhite');
        } else {
            $("#menu").removeClass('backgroundWhite');
        }
    });
    function sortByProperty(objArray, prop, direction){
        if (arguments.length<2) throw new Error("ARRAY, AND OBJECT PROPERTY MINIMUM ARGUMENTS, OPTIONAL DIRECTION");
        if (!Array.isArray(objArray)) throw new Error("FIRST ARGUMENT NOT AN ARRAY");
        const clone = objArray.slice(0);
        const direct = arguments.length>2 ? arguments[2] : 1; //Default to ascending
        const propPath = (prop.constructor===Array) ? prop : prop.split(".");
        clone.sort(function(a,b){
            for (let p in propPath){
                if (a[propPath[p]] && b[propPath[p]]){
                    a = a[propPath[p]];
                    b = b[propPath[p]];
                }
            }
            return ( (a < b) ? -1*direct : ((a > b) ? 1*direct : 0) );
        });
        return clone;
    }
    //change buttons text content
    const invisBtn = $('.invisBtn');
    if(invisBtn.length >= 1){
        const logBtn = $('#logBtn');
        const stockBtn = $('#stockBtn');
        let verifyStock = $('#stocksTable');
        let verifyTransfer = $('#transferTable');
        stockBtn.on('click',(e)=>{
            (verifyStock.hasClass("show")) ? stockBtn.text("+") : stockBtn.text("-");
            });
        logBtn.on('click', (e)=>{
            (verifyTransfer.hasClass("show")) ? logBtn.text("+") : logBtn.text("-");
        })
    }


    //fetch all stocks
    const topStocksCanvas = $('#topStocksCanvas');
    const topNegativeStocksCanvas = $('#topNegativeStocksCanvas');
    if(topStocksCanvas.length >= 1){
        const request = {fetchStocks: ""};
        $.ajax({
            type: "POST",
            url: baseUrl + "ajax/fetchStocks",
            data: request,
            dataType: "json",
            success: function(response){
                const top5 = sortByProperty(response, 'changePercent');
                drawTop5Stock(topStocksCanvas, top5, topNegativeStocksCanvas);
            },
            error: function(err){
                console.log(err)
            }
        })
    };
    // draw top 5 graphs with ajax response
    function drawTop5Stock(ctx, obj, ctx1){
        const nameMap = obj.map((e)=>e.companyName);
        
        const changeMap = obj.map((e)=>e.changePercent*100);
        let top5NegativeChart = new Chart(ctx1, {
            type: 'horizontalBar',
            data: {
                label: "Worst Change Percent",
                datasets: [{
                    label: nameMap[0],
                    data: [changeMap[0].toFixed(2)],
                    backgroundColor: "rgb(196, 38, 35)",
                    borderColor: "rgb(196, 38, 35)"
                },
                {
                    label: nameMap[1],
                    data: [changeMap[1].toFixed(2)],
                    backgroundColor: "rgb(216, 33, 30)",
                    borderColor: "rgb(216, 33, 30)"
                },
                {
                    label: nameMap[2],
                    data: [changeMap[2].toFixed(2)],
                    backgroundColor: "rgb(216, 54, 52)",
                    borderColor: "rgb(216, 54, 52)"
                },
                {
                    label: nameMap[3],
                    data: [changeMap[3].toFixed(2)],
                    backgroundColor: "rgb(237, 90, 87)",
                    borderColor: "rgb(237, 90, 87)"
                },
                {
                    label: nameMap[4],
                    data: [changeMap[4].toFixed(2)],
                    backgroundColor: "rgb(239, 118, 116)",
                    borderColor: "rgb(239, 118, 116)"
                }
            ]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: "Worst Change Percent"
                },
                scales: {
                    xAxes: [{
                        scaleLabel: {
                            beginAtZero: true,
                            display: true,
                            labelString: 'Drop %'
                            }
                        }
                    ]
                }
            }
        });
        const companyName = nameMap.reverse();
        const changePercent = changeMap.reverse();

        let top5Chart = new Chart(ctx, {
            type: 'horizontalBar',
            data: {
                label: "Best Change Percent",
                datasets: [{
                    label: companyName[0],
                    data: [changePercent[0].toFixed(2)],
                    backgroundColor: 'rgb(94, 252, 141)',
                    borderColor: 'rgb(94, 252, 141)'
                },
                {
                    label: companyName[1],
                    data: [changePercent[1].toFixed(2)],
                    backgroundColor: 'rgb(142, 249, 174)',
                    borderColor: 'rgb(142, 249, 174)'
                },
                {
                    label: companyName[2],
                    data: [changePercent[2].toFixed(2)],
                    backgroundColor: 'rgb(146, 221, 169)',
                    borderColor: 'rgb(146, 221, 169)'
                },
                {
                    label: companyName[3],
                    data: [changePercent[3].toFixed(2)],
                    backgroundColor: 'rgb(119, 209, 146)',
                    borderColor: 'rgb(119, 209, 146)'
                },
                {
                    label: companyName[4],
                    data: [changePercent[4].toFixed(2)],
                    backgroundColor: 'rgb(90, 114, 97)',
                    borderColor: 'rgb(90, 114, 97)'
                }
            ]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: "Best Change Percent"
                },
                scales: {
                    xAxes: [{
                        scaleLabel: {
                            beginAtZero: true,
                            display: true,
                            labelString: 'Change %'
                            }
                        }
                    ]
                }
            }
        })
        
    }
    //draw stock history chart
    const canvasGraph = $('#canvasGraph');
    if(canvasGraph.length >= 1) {
        const symbol = (window.location.pathname).split("/")[4];
        let = sendRequestData = {
            symbol: symbol,
            getHistory: ""
        };
        $.ajax({
            type: 'POST',
            url: baseUrl + "ajax/getStockHistory",
            data: sendRequestData,
            dataType: "json",
            success: function(response){
                const ctxStock = $('#stockCanvas').get(0).getContext("2d");
                dataStock = response;
                const stockName = dataStock[0].companyName;
                
                let dataStockOpen = dataStock.map((e)=>e.open);
                let dataStockClose = dataStock.map((e)=>e.close);

                const dateOptions = {month: 'numeric', day: 'numeric'};
                let date = dataStock.map((e)=>new Date(e.updatedAt).toLocaleDateString('pt-PT', dateOptions));
                
                let axis = dataStockOpen.concat(dataStockClose);
                let axisYStock = axis.sort((a,b)=>a-b);
                const stockChart = drawCanvasStock(ctxStock, date, dataStockOpen, dataStockClose, axisYStock, stockName);
            },
            error: function(err){
                return false;
            }
        })
    };
    function drawCanvasStock(ctx, date, dataOpen, dataClose, yaxis, name){
        let stockChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: date.reverse(),
                datasets: [
                {
                    label: "Open Price",
                    borderColor: "rgb(75, 192, 75)",
                    backgroundColor: "rgb(75, 192, 75)",
                    data: dataOpen.reverse(),
                    fill: false
                },
                {
                    label: "Close Price",
                    borderColor: "rgb(192, 75, 75)",
                    backgroundColor: "rgb(192, 75, 75)",
                    data: dataClose.reverse(),
                    fill: false
                }
            ]
            },
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: name
                },
                scales: {
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Day / Month'
                            }
                        }],
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Close price (€)'
                        },
                        ticks: {
                            beginAtZero: false,
                            min: yaxis[0],
                            max: yaxis[13]
                        }   
                    }]
                }
            }
        })
        return stockChart;
    }
   
});