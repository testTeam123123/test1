const mongoose = require('mongoose')
const Schema = mongoose.Schema
const ObjectId = Schema.Types.ObjectId
const bcrypt = require('bcrypt')
const SALT_WORK_FACTOR = 10

/**
 * 创建模型
 */
const userSchema = new Schema({
  userId: ObjectId,
  userName: {
    unique: true,
    type: String
  },
  password: String,
  comments: [{
    body: String,
    date: Date
  }],
  createTime: {
    type: Date,
    default: Date.now()
  },
  lastLoginTime: {
    type: Date,
    default: Date.now()
  }
}, {
  collection: 'user'
})

/**
 *  对密码进行加盐
 */
userSchema.pre('save', function (next) {
  // this 此处指代 Schema
  bcrypt.genSalt(SALT_WORK_FACTOR, (err, salt) => {
    if (err) return next(err)
    bcrypt.hash(this.password, salt, (err, hash) => {
      if (err) return next(err)
      this.password = hash
      next()
    })
  })
})

/**
 *  增加密码比对的方法
 */
userSchema.methods = {
  comparePassword: (_password, password) => {
    return new Promise((resolve, reject) => {
      bcrypt.compare(_password, password, (err, isMatch) => {
        if (!err) resolve(isMatch)
        else reject(err)
      })
    })
  }
}


/**
 * 发布模型
 */
mongoose.model('User', userSchema)