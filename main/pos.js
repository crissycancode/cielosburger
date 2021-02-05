// const table = document.getElementById("example1").getElementsByTagName('tbody')[0];
let menuList = [];
let count = 0;
let cartEmpty =  false;
let total = 0;
let amount = 0;
let discount = 0;
let tax = .12;
$(document).ready(function(){
  loadCart();
  userPrivilage();
  $.ajax({
    type: "POST",
    url: "modal/pos.php?do=menu",
    success: function(response) {
      menuList = response;
      menuList = JSON.parse(menuList);
    }
  });
  $.ajax({
    type: "POST",
    dataType: "text",
    async: true,
    url: "modal/pos.php?do=category",
    success: function(response) {
      response = JSON.parse(response);
      for (let i=0; i < response.length; i++){ 
        setCategories(response[i]);
      }
    }
  });
  
  $("#clear").click(function(){ //clear the cart table
//   if(document.getElementById("shiftCode").textContent == ""){
//     window.alert("please time-in before making any changes.");
//   }else{
    $.ajax({
      type: "POST",
      url: "modal/pos.php?do=clearCart",
      success: function() {
          window.location.reload();
      }
    });
//   }
  });
  
  $("input[type='checkbox']").on('click', () => { //check box for the discounts (senior/pwd)
    loadDiscount();
  });
  
  $("#cash").keyup(function() { //cash from customer
    loadCash();
  });
  
  $("#submit").click(function(){
      completeTransaction();
  });

}); // end of onload

function loadItemsToFile(){
    let element = {}, cart = [];
    let t = $('#example3').DataTable();
    let length = t.rows().data().length;

    for(let i = 0; i < length; i++){
        element = {
          item_code: t.rows(i).data()[0][0],
        // image: t.rows(i).data()[0][1];
          name: t.rows(i).data()[0][2],
          price: t.rows(i).data()[0][3],
          qty: document.getElementById("qty"+t.rows(i).data()[0][0]).innerHTML,
          total: t.rows(i).data()[0][5]
        }
        cart.push({element});
    }
    // console.log("cart: " + JSON.stringify(cart));
    return cart;
}
function completeTransaction(){
    let a = Number($("#cash").val()).toFixed(2);
    let b = Number(document.getElementById("totalDue").innerHTML);
    if( a >= b ){
        //write your ajax code here
      $.ajax({
        type: "POST",
        data: {cart: loadItemsToFile(),
            cash: Number($("#cash").val()).toFixed(2),
            total: Number(document.getElementById("totalDue").innerHTML),
            vat: Number(document.getElementById("VAT").innerHTML),
            nonvattotal: Number(document.getElementById("nonVATSale").innerHTML),
            discount: discount
        },
        url: "modal/pos.php?do=completeTransaction",
          success: function(response) {
              console.log("comeplete transaction: " + response);
            //   window.location.reload();
        }
      });
        // console.log(JSON.stringify(loadItemsToFile()));
        console.log(typeof loadItemsToFile());
        window.alert("Transaction complete.");
        
    }else{
        window.alert("Please add payment.");
    }
    
}

function userPrivilage(){
  if(document.getElementById("shiftCode").textContent == ""){
    // window.alert("please time-in before making any changes.");
    document.getElementById("clear").disabled = true;
    document.getElementById("submit").disabled = true;
  }
}

function loadCash(){
    let due = Number(document.getElementById("totalDue").innerHTML);
    let cash = Number($("#cash").val()).toFixed(2);
    if(cash >= due){
        document.getElementById("change").innerHTML = (cash - due).toFixed(2);
    }else{
        document.getElementById("change").innerHTML = "0.00";
    }
}
function loadDiscount(){
    let base = Number(amount)+Number(amount*tax);
    let  discountedAmount = 0;
    if(document.getElementById("checkDiscount").checked == true){
        discount = .20;
        discountedAmount = base - (base * discount);
       $("#totalDue").html(discountedAmount.toFixed(2));
    }
    if(document.getElementById("checkDiscount").checked == false){
        discount = 0;
        discountedAmount = base - (base * discount);
       $("#totalDue").html(base.toFixed(2));
    }
    loadCash();
}

function loadCart(){
    let isChecked = false;
    if(document.getElementById("checkDiscount").checked == true){
        isChecked = true;
    }
    total = 0;
    amount = 0;
    $.ajax({
    type: "POST",
    url: "modal/pos.php?do=cart",
    success: function(response) {
      response = JSON.parse(response);
      for(let i = 0; i < response.length; i++){
        //   count = count + 1;
        funcName(response[i].menuID, response[i].menuName, response[i].menuQuantity, response[i].menuImage, response[i].menuPrice, response[i].menuTotal, "cart");
        total = total + Number(response[i].menuQuantity);
        $("#totalQty").html(total);
        amount = Number(amount) + Number(response[i].menuTotal);
        amount = Number(amount).toFixed(2);
        $("#nonVATSale").html(amount);
        $("#VAT").html(Number(amount*.12).toFixed(2));
        $("#salesVAT").html(Number(amount)+Number(amount*.12));
        $("#totalDue").html((Number(amount)+Number(amount*.12)));
        $("input[type='checkbox']").prop('checked', isChecked);
        loadDiscount();
      }
    }
  });
}

function setCategories(category){
  let li = document.createElement('li');
  let name = JSON.stringify(category.catName);
  let catID = JSON.stringify(category.catID);
      li.innerHTML = "<a id='"+catID.replace(/['"]+/g, '')+"'data-toggle='tab' class= 'nav-item nav-link' href='#cat"+category.catID+"'>"+name.replace(/['"]+/g, '')+"</a>";
  document.getElementById("category").appendChild(li);
  let div = document.createElement('div');
      div.classList.add('tab-pane'); 
      div.classList.add('fade'); 
      div.setAttribute('id','cat'+category.catID);
      div.setAttribute('role','tabpanel');
  document.getElementById("menu").appendChild(div);
  for(let i = 0; i < menuList.length; i++){
    if(menuList[i].catID == category.catID){
      setMenu("cat"+category.catID, menuList[i]);
    }
  }
}
  
function setMenu(category,menu){
    let div = document.createElement('div');
        div.classList.add('col-sm-4');
        div.classList.add('col-xs-6');
        div.classList.add('col-md-3');
        div.classList.add('col-lg-2');
        div.setAttribute('align','center');
    let menuID = JSON.stringify(menu.catID);
    let item = document.createElement('a');
        item.classList.add('thumbnail');
        item.setAttribute('data-toggle','tab');
        item.setAttribute('rel','lightbox');
        item.style.display = "block";
        item.style.height = "220px";
        item.style.width = "150px";
    // let image = document.createElement('img');
    //     image.classList.add('rounded-circle');
    // let menuImage = "./assets/uploaded/"+menu["menuImage"];
    //     image.setAttribute('src',menuImage);
        item.setAttribute('id',"menu" + menu.menuID.replace(/['"]+/g, ''));
    let menuName = document.createElement('p');
        menuName.innerHTML = menu.menuName;
    let menuPrice = document.createElement('p');
        menuPrice.innerHTML = menu.menuPrice;
        // item.appendChild(image);
        item.appendChild(menuName);
        item.appendChild(menuPrice);
        div.appendChild(item);
        document.getElementById(category).appendChild(div);
        
        // if(document.getElementById("shiftCode").textContent == "admin" || document.getElementById("shiftCode").textContent == ""){
            item.addEventListener('click', function(e){
                e.preventDefault();
                updateCart(menu.menuID, "plus");
            });
        // }
        
        
    
}

function funcName(menuID, menuName, menuQuantity, menuImage, menuPrice, menuTotal, from){

    let plus = "plus"+menuID;
    let minus = "minus"+menuID;
    let qtyVar = "qty"+menuID;

    let quantityElement = `<span id="`+plus+`"><i class="fa fa-plus-square fa-lg" style="color:green"></i>&nbsp;&nbsp;&nbsp;</span><span id="`+qtyVar+`">`+Number(menuQuantity)+`</span><span id="`+minus+`">&nbsp;&nbsp;&nbsp;<i class="fa fa-minus-square fa-lg" style="color:red"></i></span>`;
    
    let t = $('#example3').DataTable();
        t.row.add([menuID, "image", menuName, menuPrice, quantityElement, menuTotal]).draw();
    quantityEventLister(menuID, plus, qtyVar);
    quantityEventLister(menuID, minus, qtyVar);
}

function quantityEventLister(count,operator, qtyId){
    document.getElementById(operator).addEventListener('click', function(e){
        e.preventDefault();
        sampleFunc(count,operator, qtyId);   
    });
}

function sampleFunc(index,operator, qtyId){
    let id = qtyId.replace('qty','');
    if(operator.indexOf('plus') > -1){
        updateCart(id, "plus");
    }else{
        updateCart(id, "minus");
    }
}

function updateCart(id, op){
    console.log(document.getElementById("shiftCode").textContent);
  if(document.getElementById("shiftCode").innerHTML == "admin" || document.getElementById("shiftCode").innerHTML != ""){
    $.ajax({
      type: "POST",
      data: {id, op},
      url: "modal/pos.php?do=updateCart",
      success: function(response) {
          
        checkCartForZeroQuantity();
      }
    });
  }else{
      window.alert("please time-in before making any changes.");
  }
}

function checkCartForZeroQuantity(){
    $.ajax({
      type: "POST",
      url: "modal/pos.php?do=checkCartForZeroQuantity",
      success: function(response) {
      }
    });
  refreshTable();
}

function refreshTable(){
  let t = $('#example3').DataTable();
  t.clear();
  loadCart();
}
