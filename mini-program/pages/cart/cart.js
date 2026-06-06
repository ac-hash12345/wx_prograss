const app = getApp()
Page({
  data: {
    cart: [],
    totalPrice: 0
  },
  onShow: function () {
    let cart = wx.getStorageSync('cart') || []
    cart.forEach(item => item.checked = true)
    this.setData({ cart })
    this.calcTotal()
  },
  calcTotal: function() {
    let total = 0
    this.data.cart.forEach(item => {
      if (item.checked) {
        total += item.price * item.num
      }
    })
    this.setData({ totalPrice: total.toFixed(2) })
  },
  toggleCheck: function(e) {
    let index = e.currentTarget.dataset.index
    let cart = this.data.cart
    cart[index].checked = !cart[index].checked
    this.setData({ cart })
    this.calcTotal()
  },
  incNum: function(e) {
    let index = e.currentTarget.dataset.index
    let cart = this.data.cart
    cart[index].num += 1
    this.setData({ cart })
    this.calcTotal()
    wx.setStorageSync('cart', cart)
  },
  decNum: function(e) {
    let index = e.currentTarget.dataset.index
    let cart = this.data.cart
    if (cart[index].num > 1) {
      cart[index].num -= 1
    } else {
      cart.splice(index, 1)
    }
    this.setData({ cart })
    this.calcTotal()
    wx.setStorageSync('cart', cart)
  },
  submitOrder: function() {
    let selected = this.data.cart.filter(item => item.checked)
    if (selected.length === 0) {
      return wx.showToast({ title: '请选择商品', icon: 'none' })
    }
    let userInfo = wx.getStorageSync('userInfo')
    if (!userInfo) {
      return wx.switchTab({ url: '/pages/user/user' })
    }
    
    wx.request({
      url: app.globalData.baseUrl + '/order.php?action=create',
      method: 'POST',
      data: {
        user_id: userInfo.id,
        goods: selected,
        total_price: this.data.totalPrice
      },
      success: res => {
        if (res.data.code == 200) {
          wx.showToast({ title: '下单成功' })
          let leftCart = this.data.cart.filter(item => !item.checked)
          wx.setStorageSync('cart', leftCart)
          this.setData({ cart: leftCart })
          this.calcTotal()
          setTimeout(() => {
            wx.navigateTo({ url: '/pages/order/order' })
          }, 1000)
        }
      }
    })
  }
})
