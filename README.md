---
title:  命令执行专题
date: 2019-08-3 12:12:57
tags: web
description: ctf-shelli
---

&#160; &#160; &#160; &#160;前段时间给一些的学生讲解命令执行的trick，所以今天就总结了所讲的知识点，分享出来给大家学习。这里只是把网上的资源整合在了一起，加一些自己在ctf比赛中的trick，本文章适合打CTF的初学者。<!-- more -->  
&#160; &#160; &#160; 

话不多说，直接看题目：  

level-1

其实很多CTF已经考过这个考点了也有大佬发过文章，这里简单说一下：
我们利用 >a 这种方式可以创建一个文件，然后我们可以创建一些类似 >cat >curl这样的文件。然后通过* 执行 或者 ls>a这样把文件名写入到一个文件中通过sh a 来执行。
另外我们可以使用 \ 这种续行符号来拼接命令使得我们可以在有长度限制的命令执行中执行我们想执行的命令
一图胜千言：
![1565322181162](C:\Users\95431\AppData\Roaming\Typora\typora-user-images\1565322181162.png)
这里需要注意两点
1：文件名的顺序（这里就需要经验和尝试了 另外还有一个逆序rev和一些head等取位置的技巧）
2：命令拼接后保证命令的顺利执行

代码如下
![1565322190196](C:\Users\95431\AppData\Roaming\Typora\typora-user-images\1565322190196.png)
四个长度读取flag，其实很简单，四个长度都能getshell了
首先我们创建一个cat : >cat 刚好四个字节
然后：*>a 把cat 命令执行完毕后的结果写入a
最后：我们访问a文件可得到flag
![1565322199312](C:\Users\95431\AppData\Roaming\Typora\typora-user-images\1565322199312.png)
另外利用curl通过 //命令拼接的形式可以直接getshell或者下载读取flag文件
更详细的操作参考：http://www.freebuf.com/articles/web/154453.html（文章写的还是很好的，但是这个必须需要目录有可写权限，所以还是比较鸡肋的，只能说是CTF的一个trick吧）

Level-2

源码如下：
![1565322300227](C:\Users\95431\AppData\Roaming\Typora\typora-user-images\1565322300227.png)                                           
可以看到过滤了很多字节，但是linux可以利用变量拼接命令，比如：
![1565322306869](C:\Users\95431\AppData\Roaming\Typora\typora-user-images\1565322306869.png)
这是第一个技巧

第二个就是在linux中 ${IFS} 可以替代空格 还有一个是ca$(随便输入字符)t可以绕开cat 过滤
![1565322313852](C:\Users\95431\AppData\Roaming\Typora\typora-user-images\1565322313852.png)
所以payload的有两种：1、变量拼接绕过过滤
​                                     2、$(随便输入字符) 绕过过滤 

具体payload就不给出了,这个很简单！还有就是这种过滤是可以被反弹shell的，因为暂时还有一个我出的题目用到了这个getshell，所以暂时先不放了，等过几天在补充！

Level-3

这个是以前的一道CTF题，题目是让选手绕过正则，读取flag文件，其实这里主要就是两个地方需要注意：

1、在shell环境中多个命令的分隔符除了 ; 之外还有换行符 

2、正则表达式结尾的/m ，在php中，/m表示开启多行匹配模式，开启多行匹配模式之后^和$的含义就发生了变化，没开启多行模式之前(即单行匹配模式), ^ 和$ 是匹配字符串的开始和结尾，开启多行模式之后，多行模式^,$可以匹配行的开头和尾行结尾

先看源码:
![1565322457133](C:\Users\95431\AppData\Roaming\Typora\typora-user-images\1565322457133.png)                                            
cat 一个用户输入的文件 后缀必须是txt的。

那么我们可以通过随意输入一个 .txt文件用%0a换行然后执行我们想要执行的命令

Payload：path=ls.txt%0als%20|%20head%20-n2 （查看文件名）
Payload：path=flag.txt%0Acat%20f1@g.php%0A.txt （读取flag值）

东西都很简单，docker文件放在github上了大家没事可以玩儿一下

链接：https://github.com/geeeez/ctf-shelli