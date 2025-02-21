import socket
s= socket.socket()
print('Socket successfully created')
port = 56781
s.bind(('',port))
print('socket binded to port{port}')
s.listen(5)
print('Socket is listening')
while True:
    c,addr = s.accept()
    print('Got connection from', addr)
    message = ('Thank you for connecting')
    c.send(message.encode()) #encode method used to find binary of a string msg
    c.close()
