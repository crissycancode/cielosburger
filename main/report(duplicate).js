const table = document.getElementById("example1").getElementsByTagName('tbody')[0];
const orderTable = document.getElementById("orderTable").getElementsByTagName('tbody')[0];
let comm = document.getElementById("totalCommission");
let tSales = document.getElementById("totalSales");

let totalCommReport = 0;
let totalSalesReport = 0;

let count = 0;

$(document).ready(function(){
  $("tr").remove(".odd");
  // $("#tbody").empty();
  let dateTo = document.getElementById("d2").value;
  console.log("get date: " + dateTo);
 
  let dateFrom = document.getElementById("d1").value;
  console.log("get date: " + dateFrom);
  setTimeout(() => {
    let employee = document.getElementById("employee");
    if (document.getElementById("role").innerHTML != "admin"){
      getReport(dateTo,dateFrom, document.getElementById("userid").innerHTML);
    }else{
      getReport(dateTo,dateFrom, employee.value);
      employee.addEventListener("change", function(){
        table.innerHTML = "";
        comm.value = Number(0);
        tSales.value = Number(0);
        if (document.getElementById("role").innerHTML != "admin"){
          getReport(dateTo,dateFrom, document.getElementById("userid").innerHTML);
          
        }else{
          getReport(dateTo,dateFrom, employee.value);
        }
      });
      document.getElementById("printBtn").addEventListener("click", function(){
        $("#printBtn").hide();
        $("#showBtn").hide();
        $("#footer").hide();
        window.print();
      });
    }
  }, 200);
});


function escapeString(string){
//   string = escape(string).replace("%0D%0A%0D%0A%0D%0A%0D%0A","");
  return string;
}

function getReport(to,from,id){ // inserts to tbl_cart
  count = 0;
  totalCommReport = 0;
  totalSalesReport = 0;
  $.ajax({
    type: "POST",
    data: {to,from, id},
    dataType: "text",
    async: true,
    url: "modal/report.php?do=id",
    success: function(response) {
      response = response.split("/");
    //   let length = response.length-1;
      let length = response.length;
      for(let i = 0; i < length-1; i++){
          console.log("this is the length " + length);
        addRowToTable(response[i],i);
      }
    }
  });
}

function addRowToTable(id,index){ //index is row number
  let length = table.rows.length;
  let row = table.insertRow(length);
  for(let col = 0; col < 7 ; col++){
    let column = row.insertCell(col);
    if(col === 0){
      column.innerHTML = table.rows.length;
    }else if(col === 1){
      getData(id,index,"invoice");
    }else if(col === 2){
      getData(id,index,"quantity");
    }else if(col === 3){
      getData(id,index,"total");
    }else if (col === 4){
      getData(id,index,"date");
    }else if (col === 5){
      getData(id,index,"employee");
    }else {
      getData(id,index,"commission");
      
    }
  }
}

function getData(id,index,type){
  $.ajax({
    type: "POST",
    data: {id},
    async: true,
    url: "modal/report.php?do=" + type,
    success: function(response) {
      if(type == "invoice"){
        returnInvoice(response,index);
      }
      if(type == "quantity"){
        returnQuantity(response,index);
      }
      if(type == "total"){
        returnTotal(response,index);
      }
      if(type == "date"){
        returnDate(response,index);
      }
      if(type == "commission"){
        returnCommission(response,index);
      }
      if(type == "employee"){
        returnEmployee(response,index);
      }
    }
  });
}

function returnInvoice(invoice,index){
  table.rows[index].cells[2].innerHTML ='<a href= "#invoiceDetail" id="'+ invoice +'"mycart="" onclick="orderDetails('+invoice+')" data-toggle="modal" type="submit" data-target:"#invoiceDetail" ><u>'+invoice+'</u></a>';
  
//   document.getElementById(invoice).addEventListener("click", function(){
//     document.getElementById(invoice).setAttribute("data-target", "#invoiceDetail");
//     $("#orderbody tr").remove(); 
//     orderDetails(invoice);
//   })
    // eventListener(invoice);
}

// function eventListener(invoice){
//     $("#orderbody tr").remove(); 
//     orderDetails(invoice);
// }

function orderDetails(id){
  $("#orderbody tr").remove();
  document.getElementById("invoice-number").value = id; 
//   console.log("invoice number: " + document.getElementById("invoice-number").value);
  $.ajax({
    type: "POST",
    data: {id},
    async: true,
    url: "modal/report.php?do=orderDate",
    success: function(response) {
      document.getElementById("invoice-date").value = response; 
      console.log("value of orderDate: " + document.getElementById("invoice-date").value);
    }
  });
  $.ajax({
    type: "POST",
    data: {id},
    async: true,
    url: "modal/report.php?do=orderCashier",
    success: function(response) {
      document.getElementById("invoice-cashier").value = response; 
      console.log("value of orderCashier: " + document.getElementById("invoice-cashier").value);
    }
  });
  $.ajax({
    type: "POST",
    data: {id},
    async: true,
    url: "modal/report.php?do=orderDetails",
    success: function(response) {
        console.log("value of orderDetails (before split):" + response);
      response = response.split("/");
      console.log("value of orderDetails (after split):" + response);
      let length = response.length;
      console.log("value of lenght:" + length);
      for(let i = 0; i < length-1; i++){
          if(response != ""){
              renderTable(response[i],i,id);
          }
        
        console.log("value of orderDetails:" + response);
      }
      
    }
  });
}

function renderTable(id,index,invoice){
  let length = orderTable.rows.length;
  let row = orderTable.insertRow(length);
  for(let col = 0; col < 6 ; col++){
    let column = row.insertCell(col);
    if(col === 0){
      column.innerHTML = index + 1;
    }else if(col === 1){
      column.innerHTML = id;
    }else if(col === 2){
      getMenuItem(id,index,"name");
    }else if(col === 3){
      getMenuItem(id,index,"price");
    }else if(col === 4){
      getItemQty(id,index,invoice);
    }else{
    }
  }
}

function getMenuItem(id,index,type){
  $.ajax({
    type: "POST",
    data: {id},
    async: true,
    url: "modal/report.php?do="+type,
    success: function(response) {
      if(type == "image"){
        // console.log("image:" + response);
        returnImage(response,index);
      }
      if(type == "name"){
        returnName(response,index);
      }
      if(type == "price"){
        returnPrice(response,index);
      }
    }
  });
}
function getItemQty(id,index,invoice){
  $.ajax({
    type: "POST",
    data: {id,invoice},
    async: true,
    url: "modal/report.php?do=itemQty",
    success: function(response) {
      returnItemQty(response,index);
    }
  });
}

function returnImage(image,index){
  let img = "./assets/uploaded/"+image; //image
  orderTable.rows[index].cells[1].innerHTML = `<img height="50" width="50" src="`+img+`">`;
}
function returnName(name,index){
  orderTable.rows[index].cells[2].innerHTML = name;
}
function returnPrice(price,index){
  orderTable.rows[index].cells[3].innerHTML = price;
}
function returnItemQty(price,index){
  orderTable.rows[index].cells[4].innerHTML = price;
  setTimeout(() => {
    orderTable.rows[index].cells[5].innerHTML = (Number(orderTable.rows[index].cells[3].innerHTML) * Number(orderTable.rows[index].cells[4].innerHTML)).toFixed(2);
  }, 200);
}

function returnQuantity(response,index){
  table.rows[index].cells[3].innerHTML = response;
}
function returnTotal(response,index){
  count++;
  table.rows[index].cells[4].innerHTML = response;
  totalSalesReport = totalSalesReport + Number(response);
  
  if(count == table.rows.length){
    tSales.value = Number(totalSalesReport).toFixed(2);
  }
  employeeCommission();
}
function returnDate(response,index){
  table.rows[index].cells[1].innerHTML = response;
}
function returnCommission(response,index){
  table.rows[index].cells[6].innerHTML = Number(response).toFixed(2);
}
function returnEmployee(response,index){
  table.rows[index].cells[5].innerHTML = response;
}

function employeeCommission(){
  
  if(tSales.value > 8800){
    totalCommReport = Number(tSales.value * .10);
  }else{
    totalCommReport = Number(tSales.value * .07);
  }

  if(count == table.rows.length){
    comm.value = Number(totalCommReport).toFixed(2);
    for(let i = 0; i <= table.rows.length; i++ ){
        // console.log("table lenght: " + table.rows.length + " - " + i);

    }
  }

}

