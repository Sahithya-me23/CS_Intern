import socket
import struct
import textwrap

def main():
    conn = socket.socket(socket.AF_PACKET , socket.SOCK_RAW, socket.ntohs(3))

    while True:
        raw_data , addr = conn.recvfrom(65536)
        dest_mac , src_mac ,eth_proto, data = ethernet_frame(raw_data)
        print('\n Ethernet Frame:')
        print('Destination: [], Source: [], Protocol; []'.format(dest_mac , src_mac ,eth_proto))

#unpacking the ethernet frame

def ethernet_frame(data):
    dest_mac, src_mac, proto = struct.unpack('! 6s 6s H ', data[:14])
    #we are getting 14 bytes of data
    #first 14 bytes of data we will get destination ,source and also the type
    return get_mac_addr(dest_mac), get_mac_addr(src_mac), socket.htons(proto), data[14:]

#taking MAC address and converting them into user readable format

def get_mac_addr(bytes_addr):
    bytes_str = map('{:02x}'.format, bytes_addr)
     #dividing into chunks
    return ':'.join(bytes_str).upper()

main()









