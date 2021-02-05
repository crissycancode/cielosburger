const table = document.getElementById("example1").getElementsByTagName('tbody')[0];
$(document).ready(function(){
//   console.log("shiftCode:" + document.getElementById("shiftCode").textContent);
  document.getElementById("change").innerHTML = "00.00";
  getNewInvoice();
  $("tr").remove(".odd");
  $.ajax({
    type: "GET",
    url: "modal/pos.php?do=rowCount",
    success: function(response) {
      if (response !== 0){
        getCartItemsId();
      }
    }
  });//end of rowCount
  $.ajax({
    type: "GET",
    url: "modal/pos.php?do=categoryCount",
    success: function(response) {
      getCategoryCount(response);
    }
  });//end of rowCount
});
$("#clear").click(function(){ //clear the cart table
  if(document.getElementById("shiftCode").textContent == ""){
    window.alert("please time-in before making any changes.");
  }else{
    $.ajax({
      type: "POST",
      url: "modal/pos.php?do=delete",
      success: function() {
          window.location.reload();
      }
    });
  }
});

$("input[type='checkbox']").on('click', (e) => { //check box for the discounts (senior/pwd)
  const selfEvent = $(e.currentTarget);
  if(selfEvent.prop('checked') == true){
    salesNoVAT(true);
  }
  if(selfEvent.prop('checked') == false){
    salesNoVAT(false);
  }
});

$("#cash").keyup(function() { //cash from customer
  changeTotal();
});

function changeTotal(){ // computes the change
  if(Number(document.getElementById("cash").value) > Number(document.getElementById("total").innerHTML)){
    document.getElementById("change").innerHTML = (Number(document.getElementById("cash").value) - Number(document.getElementById("total").innerHTML)).toFixed(2);
  }else{
    document.getElementById("change").innerHTML = "00.00";
  }
}

$("#submit").click(function(){ //complete the order process
  purchasesTable();
  if(document.getElementById("shiftCode").textContent == ""){
    window.alert("please time-in before placing an order.");
  }else{
    let discount = 0;
    let nonVatSale = document.getElementById("nonVATSale").innerHTML;
    let VAT = document.getElementById("VAT").innerHTML;
    let salesWithVat = document.getElementById("salesVAT").innerHTML;
    let total = document.getElementById("total").innerHTML;
    let cash = document.getElementById("cash").value;
    let change = document.getElementById("change").value;
    let rows = table.rows.length;
    if($('#checkDiscount').prop('checked') == true){
      discount = Number('.20');
    }
    $.ajax({
      type: "POST",
      data: {nonVatSale , VAT, salesWithVat, total, cash, change, rows, discount},
      dataType: "text",
      url: "modal/pos.php?do=process",
      success: function() {
    //   setTimeout(function(){
          purchasesTable();
          
    //   },500);
        
      }
    });
    getNewInvoice();
    window.location.reload();
    // console.log("hope");
  }
});



function getNewInvoice(){
  $.ajax({
    type: "GET",
    data: {},
    dataType: "text",
    url: "modal/pos.php?do=newInvoice",
    success: function() {
    }
  });
}

function getCategoryCount(count){
  $.ajax({
    type: "GET",
    async: true,
    url: "modal/pos.php?do=category",
    success: function(response) {
      document.getElementById("category").innerHTML = response;
      $.ajax({   //inital display of buy 1 take 1 before any button is clicked
        type: "POST",
        async: true,
        data: {id:1},
        url: "modal/pos.php?do=menu",
        success: function(response) {
          document.getElementById("pb").innerHTML = response;
        }
      });
 
      for(let i = 1; i <= count; i++){
        document.getElementById(i).addEventListener("click", function(){
          let id = i;
          $.ajax({
            type: "POST",
            async: true,
            data: {id},
            url: "modal/pos.php?do=menu",
            success: function(response) {
              document.getElementById("pb").innerHTML = response;
            }
          });
        });
      }
    }
  }); // category and menu 
}

function purchasesTable(){
  for (let i = 0; i < table.rows.length; i++){
    let menuId = table.rows[i].cells[0].innerHTML;
    let quantity = table.rows[i].cells[4].firstChild.innerHTML;;
    let total = table.rows[i].cells[5].innerHTML;
    let price = table.rows[i].cells[3].innerHTML;
    $.ajax({
      type: "POST",
      data: {menuId,quantity,total,price},
      dataType: "text",
      url: "modal/pos.php?do=purchases",
      success: function() {
          window.location.reload();
      }
    });
  }
}




function escapeString(string){
//   string = escape(string).replace("%0D%0A%0D%0A%0D%0A%0D%0A","");
  return string;
}

function getCartItemsId(){
  $.ajax({
    type: "GET",
    url: "modal/pos.php?do=getCartItemsId",
    success: function(response) {
      response = escapeString(response);
      response = response.split("/");
      let length = response.length-1;
      for(let i = 0; i < length; i++){
        addRowToTable(response[i],i,"fromCart");
      }
    }
  });
  salesNoVAT(false);
}

function addRowToTable(id,index,type){ //index is row number
  let length = table.rows.length;
  let row = table.insertRow(length);
  for(let col = 0; col < 6 ; col++){
    let column = row.insertCell(col);
    if(col === 0){
      column.innerHTML = id; //code
    }else if(col === 1){
      getData(id,index,"image");
    }else if(col === 2){
      getData(id,index,"name");
    }else if(col === 3){
      getData(id,index,"price");
    }else if(col === 4){
      getData(id,index,"quantity");
    }else{
      getData(id,index,"total");
    }
  }
}

function getData(id,index,type){
  $.ajax({
    type: "POST",
    data: {id},
    async: true,
    url: "modal/pos.php?do="+type,
    success: function(response) {
      if(type === "image"){
        returnImage(response,index);
      }
      if(type === "name"){
        returnName(response,index);
      }
      if(type === "price"){
        returnPrice(response,index);
      }
      if(type === "quantity"){
        returnQuantity(response,index);
      }
      if(type === "total"){
        returnTotal(index);
      }
    }
  });
}

function returnImage(image,index){
  let img = "./assets/uploaded/"+image; //image
  table.rows[index].cells[1].innerHTML = `<img height="50" width="50" src="`+img+`">`;
}
function returnName(name,index){
  table.rows[index].cells[2].innerHTML = name; //name
}

function returnPrice(price,index){
  table.rows[index].cells[3].innerHTML = Number(price).toFixed(2); //name
}

function returnQuantity(quantity,index){ //creates quantity id
  let id = "qtyId_"+table.rows[index].cells[0].innerHTML;
  table.rows[index].cells[4].innerHTML = `<span id="`+id+`">`+Number(quantity)+`</span><span id="`+index+`">&nbsp;&nbsp;&nbsp;<i class="fa fa-minus-square fa-lg text-warning" style="color:orange"></i></span>`;
  setTimeout(() => { //total
    minusButtonEvent(index, index);
  }, 200);
}

function returnTotal(index){
    setTimeout(() => { 
        //total
      let x = table.rows[index].cells[3].innerHTML;
      let y = table.rows[index].cells[4].firstChild.innerHTML;
      table.rows[index].cells[5].innerHTML = (x * y).toFixed(2);
      salesNoVAT($('#checkDiscount').prop('checked'));
    }, 500);
}

function onClickFunction(id){
  if(document.getElementById("shiftCode").textContent ==""){
    window.alert("please time in");
  }else{
    if (table.rows.length != 0) {
      checkItem(id);
    }else{ 
      updateCart(id, 1);
      addRowToTable(id,table.rows.length,"new");
    }
  }
}

function checkItem(id){
  let duplicate = false;
  for(let i = 0; i < table.rows.length; i++){
    if(table.rows[i].cells[0].innerHTML == id){
      table.rows[i].cells[4].firstChild.innerHTML = Number(table.rows[i].cells[4].firstChild.innerHTML) + Number(1);
      returnTotal(i);
      updateCart(id, Number(table.rows[i].cells[4].firstChild.innerHTML));
      duplicate = true;
    }
  } 
  if(duplicate !== true){
    updateCart(id, 1);
    addRowToTable(id,table.rows.length,"new");
  }
}

function updateCart(menuId, menuQty){ // inserts to tbl_cart
  // salesNoVAT($('#checkDiscount').prop('checked'));
  $.ajax({
    type: "POST",
    data: {menuId, menuQty},
    dataType: "text",
    async: true,
    url: "modal/pos.php?do=addToCart",
    success: function(response) {
    }
  });
}
function deleteItem(menuId){ // inserts to tbl_cart
  // salesNoVAT($('#checkDiscount').prop('checked'));
  $.ajax({
    type: "POST",
    data: {menuId},
    dataType: "text",
    async: true,
    url: "modal/pos.php?do=deleteItem",
    success: function(response) {

    }
  });
}

function salesNoVAT(discount){
  $.ajax({
    type: "GET",
    dataType: "text",
    async: true,
    url: "modal/pos.php?do=totalCartItemsAmount",
    success: function(response) {
      document.getElementById("salesVAT").innerHTML = response;
      document.getElementById("VAT").innerHTML = (Number(response) * (.12)).toFixed(2);
      document.getElementById("nonVATSale").innerHTML = (Number(response) - Number(document.getElementById("VAT").innerHTML)).toFixed(2);
      if(discount === true){
        document.getElementById("total").innerHTML = (Number(document.getElementById("salesVAT").innerHTML) * .80).toFixed(2);
      }else{
        document.getElementById("total").innerHTML = (Number(document.getElementById("salesVAT").innerHTML)).toFixed(2);
      }
      changeTotal();
    }
  });
}

function minusButtonEvent(btnId, index){
  let  button = document.getElementById(btnId);
  button.addEventListener("click", function(){
    if(document.getElementById("shiftCode").textContent ==""){
      window.alert("please time in");
    }else{
      table.rows[index].cells[4].firstChild.innerHTML = Number(table.rows[index].cells[4].firstChild.innerHTML) - Number(1);
      updateCart(table.rows[index].cells[0].innerHTML, table.rows[index].cells[4].firstChild.innerHTML);
      returnTotal(index);
      if(Number(table.rows[index].cells[4].firstChild.innerHTML) <= 0){
        deleteItem(table.rows[index].cells[0].innerHTML);
        table.deleteRow(index);
      }
      
    }
  });
}