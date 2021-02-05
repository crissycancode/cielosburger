const table = document.getElementById("example1").getElementsByTagName('tbody')[0];
const orderTable = document.getElementById("modalTable").getElementsByTagName('tbody')[0];
let tcomm = document.getElementById("totalCommission");
let tSales = document.getElementById("totalSales");

let totalCommReport = 0;
let totalSalesReport = 0;
let count = 0;
let ordercount = 0;

$(document).ready(function(){
  $("tr").remove(".odd");
  let dateTo = document.getElementById("d2").value;
  let dateFrom = document.getElementById("d1").value;
  let employee = 0;
  let role = document.getElementById("role").innerHTML;
  if(role == "admin"){
      employee = document.getElementById("employee").value;
  }else{
      employee = document.getElementById("userid").innerHTML;
  }
  dateFrom = $(this).val();
  getReport(dateFrom,dateTo,employee);
  $('#d1').change(function() {
    table.innerHTML="";
    dateFrom = $(this).val();
    getReport(dateFrom,dateTo,employee);
  });
  $('#d2').change(function() {
    dateTo = $(this).val();
    getReport(dateFrom,dateTo,employee);
  });
  $('#employee').change(function() {
    employee = $(this).val();
    getReport(dateFrom,dateTo,employee);
  });
});

function getReport(from,to,id){
  table.innerHTML=""; 
  count = 0;
  totalCommReport = 0;
  totalSalesReport = 0;
  $('#example1').DataTable().clear();
  $.ajax({
    type: "POST",
    data: {to,from, id},
    dataType: "text",
    async: true,
    url: "modal/report.php?do=id",
    success: function(response) {
      let length = response.length;
      console.log("length : " + length);
      console.log("type: " + typeof response);
      console.log("array: " + response);
      response = JSON.parse(response);
      for (let i=0; i< response.length; i++){ 
        printObject(response[i]);
      }
    }
  });
}
function printObject(response){
    count = count + 1;
    addRowToTable(response["purchasedate"], response["invoice"],response["total"] , response["firstname"],response["lastname"],response["qty"], response["comm"]);
}

function addRowToTable(date, invoice,total ,firstname, lastname, qty, comm){ //index is row number
    // $("#modalTable").DataTable().clear();
    // orderTable.innerHTML = "";
    document.getElementById("invoice-cashier").value = "";
    document.getElementById("invoice-date").value = "";
    document.getElementById("invoice-number").value = "";
    let fullname = firstname + " " + lastname;
    let invoiceurl = '<a href= "#invoiceDetail" id="'+ invoice +'"mycart="" onclick="orderDetails('+invoice+')" data-toggle="modal" type="submit" data-target:"#invoiceDetail" cashier = "'+fullname+'" ordate="'+date+'"><u>'+invoice+'</u></a>';
    let t = $('#example1').DataTable();
        t.row.add([count, date, invoiceurl, qty, total,firstname + " " +lastname, comm]).draw();
    totalSalesReport = Number(totalSalesReport)+ Number(total);
    tSales.value = Number(totalSalesReport).toFixed(2);
    totalCommReport = Number(totalCommReport)+ Number(comm);
    
    console.log("total comm" + totalCommReport);
    tcomm.value = Number(totalCommReport).toFixed(2);
}

function orderDetails(invoice){
  ordercount = 0;
  orderTable.innerHTML = "";
  $("#modalTable").DataTable().clear();
  document.getElementById("invoice-cashier").value = document.getElementById(invoice).getAttribute("cashier");
  document.getElementById("invoice-date").value = document.getElementById(invoice).getAttribute("ordate");
  document.getElementById("invoice-number").value = invoice;
  $.ajax({
    type: "POST",
    data: {invoice},
    dataType: "text",
    async: true,
    url: "modal/report.php?do=invoice",
    success: function(response) {

        console.log("order details: " + response);
        console.log("order details: " + response);
        response = JSON.parse(response);
      
      for (let i=0; i< response.length; i++){ 
        console.log("data table: " + response);
        orderObjects(response[i]);
      }
    }
  });
  
}
function orderObjects(response){
    ordercount = ordercount + 1;
    console.log("quantity:" + response["qty"]);
    addOrderDetails(response["item"], response["qty"], response["price"], response["total"]);
}

function addOrderDetails(item, quantity, price, totalperitem){ //index is row number
    let order = $('#modalTable').DataTable();
    console.log("details: " + ordercount, item, quantity, price, totalperitem);
    order.row.add([ordercount, item , price, quantity, totalperitem]).draw();
}

$("#btnPrint").click(function(){
    window.print();
});












// function renderTable(id,index,invoice){
//   let length = orderTable.rows.length;
//   let row = orderTable.insertRow(length);
//   for(let col = 0; col < 6 ; col++){
//     let column = row.insertCell(col);
//     if(col === 0){
//       column.innerHTML = index + 1;
//     }else if(col === 1){
//       column.innerHTML = id;
//     }else if(col === 2){
//       getMenuItem(id,index,"name");
//     }else if(col === 3){
//       getMenuItem(id,index,"price");
//     }else if(col === 4){
//       getItemQty(id,index,invoice);
//     }else{
//     }
//   }
// }

// function getMenuItem(id,index,type){
//   $.ajax({
//     type: "POST",
//     data: {id},
//     async: true,
//     url: "modal/report.php?do="+type,
//     success: function(response) {
//       if(type == "image"){
//         // console.log("image:" + response);
//         returnImage(response,index);
//       }
//       if(type == "name"){
//         returnName(response,index);
//       }
//       if(type == "price"){
//         returnPrice(response,index);
//       }
//     }
//   });
// }
// function getItemQty(id,index,invoice){
// //   $.ajax({
// //     type: "POST",
// //     data: {id,invoice},
// //     async: true,
// //     url: "modal/report.php?do=itemQty",
// //     success: function(response) {
// //       returnItemQty(response,index);
// //     }
// //   });
// }

// function returnImage(image,index){
//   let img = "./assets/uploaded/"+image; //image
//   orderTable.rows[index].cells[1].innerHTML = `<img height="50" width="50" src="`+img+`">`;
// }
// function returnName(name,index){
//   orderTable.rows[index].cells[2].innerHTML = name;
// }
// function returnPrice(price,index){
//   orderTable.rows[index].cells[3].innerHTML = price;
// }
// function returnItemQty(price,index){
//   orderTable.rows[index].cells[4].innerHTML = price;
//   setTimeout(() => {
//     orderTable.rows[index].cells[5].innerHTML = (Number(orderTable.rows[index].cells[3].innerHTML) * Number(orderTable.rows[index].cells[4].innerHTML)).toFixed(2);
//   }, 200);
// }

// function returnQuantity(response,index){
//   table.rows[index].cells[3].innerHTML = response;
// }
// function returnTotal(response,index){
//   count++;
//   table.rows[index].cells[4].innerHTML = response;
//   totalSalesReport = totalSalesReport + Number(response);
  
//   if(count == table.rows.length){
//     tSales.value = Number(totalSalesReport).toFixed(2);
//   }
//   employeeCommission();
// }
// function returnDate(response,index){
//   table.rows[index].cells[1].innerHTML = response;
// }
// function returnCommission(response,index){
//   table.rows[index].cells[6].innerHTML = Number(response).toFixed(2);
// }
// function returnEmployee(response,index){
//   table.rows[index].cells[5].innerHTML = response;
// }

// function employeeCommission(){
  
//   if(tSales.value > 8800){
//     totalCommReport = Number(tSales.value * .10);
//   }else{
//     totalCommReport = Number(tSales.value * .07);
//   }

//   if(count == table.rows.length){
//     comm.value = Number(totalCommReport).toFixed(2);
//     for(let i = 0; i <= table.rows.length; i++ ){
//         // console.log("table lenght: " + table.rows.length + " - " + i);

//     }
//   }

// }

