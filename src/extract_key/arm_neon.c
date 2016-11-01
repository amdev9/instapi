


#include <arm_neon.h>

uint64_t* foo(uint64_t* x, uint32_t y)
{
uint64x2_t d = vreinterpretq_u64_u32(vdupq_n_u32(y));
vst1q_u64(x, d);
x+=2;


return x;
}

/////



// The 128-bit register Q8 is an alias for 2 consecutive 64-bit registers D16 and D17 but does not have an alias 
// using the 32
// vmov.i32 q8, #0          \n\t"  //clear our accumulator register
// @ CHECK: vst1.64 {d16, d17}, [r0]       @ encoding: [0xcf,0x0a,0x40,0xf4]


// VMOV (between two ARM registers and an extension register)
// Transfer contents between two ARM registers and a 64-bit extension register, or two consecutive 32-bit VFP registers.


// VDUP (Vector Duplicate) duplicates a scalar into every element of the destination vector. The source can be a NEON scalar or an ARM register.

// mov	r0, #0
// vdup.32	q8, r0

vdup.32	q8, r1
vst1.64	{d16-d17}, [r0:64]!  // Stores all lanes or a single lane of a vector.

bx	lr