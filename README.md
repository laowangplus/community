
# 个人社区简介

## 注意点
1、上传文件在/storage/app/public中，因为项目访问在/public下，所以
创建/public/storager软连接指向/storage/app/public（转移项目时，需要
手动创建软连接）

2、获取项目后，需要 composer update 更新vender文件夹。

3、复制.env.example文件并更名为.env，更改自己的数据库缓存等账号与密码